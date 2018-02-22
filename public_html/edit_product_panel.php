<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";

$loged_in=false;
$admin=false;
$logout_button="";
$admin_button="";

$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

if(!$loged_in or !$admin)
    header("Location: login.php");
else
{
    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
    
    $answer="";
    $answer2="";
    if(!empty($_POST['submit']) and !empty($_POST['product_name']) and !empty($_POST['product_quantity']) and  !empty($_POST['product_price']))
    {   
        
        foreach($_POST as $k=>$v) {$_POST[$k]=test_input($v,$link);}

        try
        {
            mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
            mysqli_query($link,"START TRANSACTION ;");

            $q1=mysqli_query($link,"SELECT idKategorii FROM Kategorie WHERE nazwa='$_POST[product_category]';");
            if(!$q1)
                throw new Exception();

            $categories_q=mysqli_fetch_assoc($q1);

            $q2=mysqli_query($link,"SELECT idMarki FROM Marki WHERE nazwa='$_POST[product_brand]';");
            if(!$q2)
                throw new Exception();

            $brands_q=mysqli_fetch_assoc($q2);

            $flag=true;

            if(mysqli_num_rows($q1)==0)
            {
                $answer=$answer."Niepoprawna kategoria<br>";
                $flag=false;
            }

            if(mysqli_num_rows($q2)==0)
            {
                $answer=$answer."Niepoprawna marka<br> ";
                $flag=false;
            }

            $q3=mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE nazwa='$_POST[product_name]' AND idProduktu!=$_POST[submit];");
            if(!$q3)
                throw new Exception();

            $name_q=mysqli_fetch_assoc($q3);
            if($name_q['cnt']>0)
            {
                $answer=$answer."Produkt o takiej nazwie już istnieje<br> ";
                $flag=false;
            }

            elseif(strlen($_POST['product_name'])<=0 or strlen($_POST['product_name'])>50)
            {
                $answer.="Niepoprawna nazwa produktu<br> ";
            }

            if(is_numeric($_POST['product_quantity']))
            {
                if($_POST['product_quantity']<0 || $_POST['product_quantity']>999999)
                {
                    $answer.="Niepoprawna ilość<br> ";
                    $flag=false;
                }
            }
            else
            {
                $answer.="Niepoprawna ilość<br> ";
                $flag=false;
            }

            if(!empty($_POST['product_desc']))
            {
                $_POST['product_desc']=trim($_POST['product_desc']);

                if(strlen($_POST['product_desc'])>=21844)
                {
                    $answer.="Opis jest za długi<br> ";
                    $flag=false;
                }
            }
            

            if(!is_numeric($_POST['product_price']) || $_POST['product_price']<0 || $_POST['product_price']>9999)
            {
                $answer.="Niepoprawna cena<br> ";
                $flag=false;
            }


            //file upload
            $target_file="";
            $file_exists=false;
            if(file_exists($_FILES['file-upload']['tmp_name']) and is_uploaded_file($_FILES['file-upload']['tmp_name']) and !empty($_FILES['file-upload']['name']))
            {    
                
                $target_dir = "products_images/";
                $target_file = $target_dir . basename($_FILES["file-upload"]["name"]);
                $uploadOk = true;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                $check = getimagesize($_FILES["file-upload"]["tmp_name"]);
                if($check == false) 
                {
                    $answer.="Plik nie jest zdjęciem<br> ";
                    $uploadOk = false;
                }

                if (file_exists($target_file)) 
                {
                    $file_exists=true;
                }

                if ($_FILES["file-upload"]["size"] > 500000) 
                {
                    $answer.="Plik jest zbyt duży<br> ";
                    $uploadOk = false;
                }
                    
                    
                $imageFileType=strtolower($imageFileType);
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    $answer.=$imageFileType ;
                    $answer.="Dozwolony format pliku to: JPG, JPEG, PNG & GIF";
                    $uploadOk = false;
                }

                if ($uploadOk == false) 
                {
                    $flag=false;
                } 
                else if(!$file_exists)
                {
                    if (!move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) 
                    {
                        $flag=false;
                        $answer.="Wystąpił błąd podczas ładowania pliku<br> ";
                    }
                }
            }
            //end of file upload

            if($flag==true)
            {
                $product_id=test_input($_POST['submit'],$link);
                mysqli_query($link,"SAVEPOINT S1");
                $q4=mysqli_query($link,"UPDATE Produkty SET nazwa='$_POST[product_name]',opis='$_POST[product_desc]', idKategorii=$categories_q[idKategorii],idMarki=$brands_q[idMarki],ilosc='$_POST[product_quantity]',cena='$_POST[product_price]' WHERE idProduktu=$product_id;");

                if(!$q4)
                    mysqli_query($link,"ROLLBACK TO SAVEPOINT S1");
                
                if(!empty($target_file))
                {
                    mysqli_query($link,"SAVEPOINT S2");
                    
                    $q5=mysqli_query($link,"DELETE FROM Zdjecia WHERE idProduktu=$product_id;");
                    if(!$q5)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT S2");
                    
                    $q6=mysqli_query($link,"INSERT INTO Zdjecia (idProduktu,link) VALUES ($product_id,'$target_file');");
                    if(!$q6)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT S2");
                    
                }
                
                $answer2.='Pomyślnie edytowano produkt';
                mysqli_query($link,"COMMIT");
            }
            else
            {
                $answer.='Produkt nie został zedytowany';
                mysqli_query($link,"ROLLBACK");
            }
        }
        catch(Exception $e)
        {
            mysqli_query($link,"ROLLBACK");
            $answer.='Produkt nie został zedytowany';
        }
    }

    
    
    if(isset($_POST['edit_button']) or isset($_POST['submit']))
    {   
        try
        {
            if(isset($_POST['edit_button']))
                $product_id=test_input($_POST['edit_button'],$link);
            else
                $product_id=test_input($_POST['submit'],$link);

            $q=mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE idProduktu=$product_id;");

            if(!$q)
                throw new Eception();

            $q_assoc=mysqli_fetch_assoc($q);
            
            if($q_assoc['cnt']<=0)
            {
                mysqli_close($link);
                header("Location: admin_panel.php");
                exit();
            }
            else
            {
                $q2=mysqli_query($link,"SELECT p.*,z.link FROM Produkty p LEFT JOIN Zdjecia z ON z.idProduktu=p.idProduktu WHERE p.idProduktu=$product_id;");
                
                if(!$q2)
                    throw new Eception();
                
                $product_q=mysqli_fetch_assoc($q2);
                
                $select_categories_q=mysqli_query($link,"SELECT * FROM Kategorie;");
                if(!$select_categories_q)
                    throw new Eception();
                
                $categories="";
                while($row=mysqli_fetch_assoc($select_categories_q))
                {
                    if($row['idKategorii']==$product_q['idKategorii'])
                        $categories=$categories."<option selected>".$row['nazwa']."</option>";
                    else
                        $categories=$categories."<option >".$row['nazwa']."</option>";
                }    


                $select_brands_q=mysqli_query($link,"SELECT * FROM Marki;");
                if(!$select_brands_q)
                    throw new Eception();
                
                $brands="";
                while($row=mysqli_fetch_assoc($select_brands_q))
                {
                    if($row['idMarki']==$product_q['idMarki'])
                        $brands=$brands."<option selected>".$row['nazwa']."</option>"; 
                    else
                        $brands=$brands."<option>".$row['nazwa']."</option>"; 
                }
            } 
        }
        catch(Exception $e)
        {
            mysqli_close($link);
            header("Location: admin_panel.php");
            exit();
        }
    }
    else
    {
        mysqli_close($link);
        header("Location: admin_panel.php");
        exit();
    }   
    
}
mysqli_close($link);
?>


<!DOCTYPE html>
<head lang="pl">
    <title>Edytuj produkt</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/admin.ico" />
    <meta name="author" content="Miłosz Szlachetka">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" type="text/css" href="fontello_css/fontello.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
<div class="admin_background"></div>
<div class="container"> 
    <div class="row">
        <div class="col-sm-3" style="padding-top:20px;">
            <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript>
            <center><button  class="btn btn-default btn-success btn-lg" type="button" onClick="javascript:window:location.href='index.php';">Sklep</button><!--id="admin_shop_button"--></center>
        </div>
        <div class="col-sm-6">
            <h1 class="admin_h1"><a href="admin_panel.php" class="white_a admin_h1">Panel Administratora</a></h1>
        </div>
        <div class="col-sm-3" style="padding-top:20px;">
            <form action="logout.php" method="POST">
                    <center><button  name="logout_button" class="btn btn-success btn-lg" type="submit">Wyloguj</button> </center>        <!--id="admin_logout_button"-->       
            </form>
        </div>
    </div>   
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(isset($answer)) echo $answer; ?></h1></div>
    <div id="admin_answer2" style="color:#8af294;text-align:center;"><h1><?php if(isset($answer2)) echo $answer2; ?></h1></div>
    <div id="admin_panel">
        <div class="add_panel" style="color:white;">
        <h2>Edycja Produktu</h2>
            <br>
            
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-sm-1"></div>
            <div class="col-sm-5 admin_menu1">
                <input class="form-control in" type="text" name="product_name" placeholder="Nazwa produktu" required pattern=".{1,50}" title="1-50 znaków" value="<?php if(isset($product_q)) echo $product_q['nazwa'];?>">
                <input class="form-control in" type="number" step="1" max="999999" min="0" name="product_quantity" placeholder="Ilość sztuk" value="<?php if(isset($product_q)) echo $product_q['ilosc'];?>">
                <input class="form-control in" type="number" step="0.01" max="9999.99" min="0.00" name="product_price" placeholder="Cena" value="<?php if(isset($product_q)) echo $product_q['cena'];?>">
                <select class="form-control in" name="product_category" required>
                        <option>Kategoria</option>
                        <?php
                            if(!empty($categories)) echo $categories;  
                        ?>
                </select>
                <select class="form-control in" name="product_brand">
                        <option>Marka</option>
                        <?php
                            if(!empty($brands)) echo $brands;  
                        ?>
                </select>
                <label for="file-upload" class="custom-file-upload">
                        Wybierz zdjęcie
                    </label>
                    <input id="file-upload" name="file-upload" type="file" style="display:none"/>
                    <br><br><br>
                    <p>
                    <img style="border:5px solid white" src="<?php if(isset($product_q) and $product_q['link']!="") echo $product_q['link']; /*elseif(isset($target_file)) echo $target_file; */?>" alt="Brak zdjęcia">
                    <figcaption>Podgląd zdjęcia</figcaption>
                    </p>
            </div>
            <div class="col-sm-5">
                <textarea maxlength="9999" class="form-control in admin" placeholder="Opis produktu" name="product_desc" cols="40" rows="5" ><?php if(isset($product_q)) echo $product_q['opis'];?></textarea>
            </div>
            <div class="col-sm-1">
            </div>
            <br>
            <br>
            <br>
            <div class="row"></div>
            <div class="row" style="padding:30px;">
                <button type="submit" class="btn btn-success btn-lg" value="<?php if(isset($product_q)) echo $product_q['idProduktu'];?>" name="submit" class="add_product_button">Edytuj</button>
            </div>
            
            </div>
        </div>
        </div>   
</body>
</html>