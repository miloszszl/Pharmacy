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

foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
                

if(!($admin && $loged_in))
{
    header('Location:index.php');
}
else
{
    $answer="";
    $answer2="";
    if(isset($_POST['submit']))
    {   
        
        foreach($_POST as $k=>$v) {$_POST[$k]=test_input($v,$link);}
        if(!empty($categories_q['idKategorii'])  or !empty($categories_q['idMarki']) or !empty($categories_q['product_name']) or !empty($categories_q['product_price']) or !empty($categories_q['product_quantity']))
        {
            $answer.="Niepoprawne dane";
        }
        else
        {
            try
            {

               
                mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                mysqli_query($link,"START TRANSACTION;");

                $q1=mysqli_query($link,"SELECT idKategorii FROM Kategorie WHERE nazwa='$_POST[product_category]';");
                if(!$q1)
                    throw new Exception();
                $categories_q=mysqli_fetch_assoc($q1);

                $q2=mysqli_query($link,"SELECT idMarki FROM Marki WHERE nazwa='$_POST[product_brand]';");
                if(!$q2)
                    throw new Exception();
                $brands_q=mysqli_fetch_assoc($q2);
             
                $flag=true;

                if(is_null($categories_q['idKategorii']))
                {
                    $answer=$answer."Niepoprawna kategoria<br>";
                    $flag=false;
                }

                if(is_null($brands_q['idMarki']))
                {
                    $answer=$answer."Niepoprawna marka<br> ";
                    $flag=false;
                }

                $q3=mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE nazwa='$_POST[product_name]';");
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

                if(isset($_POST['product_desc']))
                {
                    $_POST['product_desc']=trim($_POST['product_desc']);

                    if(strlen($_POST['product_desc'])>=21844)
                    {
                        $answer.="Opis jest za długi<br> ";
                        $flag=false;
                    }
                }

                if(is_numeric($_POST['product_price']))
                {
                    if($_POST['product_price']<0 || $_POST['product_price']>9999)
                    {
                        $answer.="Niepoprawna cena<br> ";
                        $flag=false;
                    }
                }
                else
                {
                    $answer.="Niepoprawna cena<br> ";
                    $flag=false;
                }

                //file upload
                $target_file="";
                if(file_exists($_FILES['file-upload']['tmp_name']) and is_uploaded_file($_FILES['file-upload']['tmp_name']))
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
                        //$answer.="Takie zdjęcie już istnieje<br> ";
                        $uploadOk = false;
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
                        $answer.="Dozwolony format pliku to: JPG, JPEG, PNG & GIF<br>";
                        $uploadOk = false;
                    }

                    if ($uploadOk == false) 
                    {
                        //$flag=false;
                    } 
                    else 
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
                    mysqli_query($link,"SAVEPOINT S1");
                    
                    $q4=mysqli_query($link,"INSERT INTO Produkty (nazwa,opis,ilosc,idKategorii,idMarki,cena) VALUES ('$_POST[product_name]','$_POST[product_desc]','$_POST[product_quantity]','{$categories_q['idKategorii']}','$brands_q[idMarki]','$_POST[product_price]');");
                    
                    if(!$q4)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT S1");
                    
                    
                    $product_id=mysqli_insert_id($link);
                    mysqli_query($link,"SAVEPOINT S2");
                    $q5=mysqli_query($link,"INSERT INTO Zdjecia (idProduktu,link) VALUES ($product_id,'$target_file');");

                    if(!$q5)
                        mysqli_query($link,"ROLLBACK TO SAVEPOINT S2");
                    
                    if(!mysqli_error($link))
                    {
                        $answer2.='Pomyślnie dodano produkt<br>';
                        mysqli_query($link,"COMMIT");
                    }
                    else
                    {
                        $answer.='Produkt nie został dodany<br>';
                        mysqli_query($link,"ROLLBACK");
                    }
                    
                    
                }
                else
                {
                    $answer.='Produkt nie został dodany<br>';
                    mysqli_query($link,"ROLLBACK");
                }
            }
            catch(Exception $e)
            {
                $answer.="Operacja zostala przerwana<br>";
                mysqli_query($link,"ROLLBACK");
            }
        }
    }


    $select_categories_q=mysqli_query($link,"SELECT * FROM Kategorie;");
    if($select_categories_q)
    {
        $categories="";
        while($row=mysqli_fetch_assoc($select_categories_q))
        {
            $categories=$categories."<option>".$row['nazwa']."</option>"; 
        }    
    }

    $select_brands_q=mysqli_query($link,"SELECT * FROM Marki;");
    if($select_brands_q)
    {
        $brands="";
        while($row=mysqli_fetch_assoc($select_brands_q))
        {
            $brands=$brands."<option>".$row['nazwa']."</option>"; 
        }
    }
    
}
mysqli_close($link);
?>


<!DOCTYPE html>
<head lang="pl">
    <title>Dodaj produkt</title>
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
    <div class="row" style="margin-top:30px;">
    <div class="row"><div id="admin_answer" style="color:#fc7676;text-align:center;"><?php if(isset($answer)) echo "<h2>".$answer."</h2>"; ?></div></div>
        <div class="row"><div id="admin_answer2" style="color:#8af294;text-align:center;"><h1><?php if(isset($answer2)) echo $answer2; ?></h1></div></div>
    
    <div id="admin_panel">
        <div class="add_panel">
        <h2 style="color:white;">Dodawanie produktu</h2>
            
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="col-sm-1"></div>
            <div class="col-sm-5 admin_menu1">
                    <input class="form-control in" type="text" name="product_name" placeholder="Nazwa produktu" required pattern=".{1,50}" title="1-50 znaków">
                    <!--<input class="admin_input" type="text" name="product_quantity" placeholder="Ilość sztuk">
                    <input class="admin_input" type="text" name="product_price" placeholder="Cena" required>-->
                    <input type="number" class="form-control in" step="1" max="999999" min="0" name="product_quantity" placeholder="Ilość sztuk">
                    <input  class="form-control in" type="number" step="0.01" max="9999.99" min="0.00" name="product_price" placeholder="Cena">
                    <select class="form-control in" name="product_category" required>
                        <option>Kategoria</option>
                        <?php
                            if(isset($categories)) echo $categories;  
                        ?>
                    </select>
                    <select  class="form-control in" name="product_brand">
                        <option>Marka</option>
                        <?php
                            if(isset($brands)) echo $brands;  
                        ?>
                    </select>
                    
                    <label for="file-upload" class="custom-file-upload">
                        Wybierz zdjęcie
                    </label>
                    <input id="file-upload" name="file-upload" type="file" style="display:none"/>
            </div>
            
            <div class="col-sm-5">
                <textarea class="form-control in admin" maxlength="9999" class="admin_desc" placeholder="Opis produktu" name="product_desc" cols="40" rows="5" ></textarea>
            </div>
            <div class="col-sm-1">
            </div>
            <br>
            <br>
            <br>
            <div class="row"></div>
            <div class="row" style="padding:30px;">
                <button type="submit" name="submit" class="btn btn-success btn-lg">Dodaj</button>
            </div>
            
        </form>
        </div>         
    </div>
        
    </div>
</div> 
</body>
</html>