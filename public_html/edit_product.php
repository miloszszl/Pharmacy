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
    exit();
}
else
{
    $products_data="";
        
    if(isset($_POST['search']) or isset($_GET['search']))
    {
        if(isset($_POST['search']))
            $search=test_input($_POST['search'],$link);
        else
            $search=test_input($_GET['search'],$link);

        $all_products=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE levenshtein(LOWER(nazwa),LOWER('$search')) < 3;"));
        if($all_products['cnt']>0)
        {
            //pagination
            $all_products=$all_products['cnt'];
            $on_page = 10; //ilość leków na stronie
            $nav_limit= 5; //ilość wyświetlanych numerów stron
            $all_pages=ceil($all_products/$on_page);
            //echo $all_pages;
            if(isset($_GET['page_num']) and is_numeric($_GET['page_num']))
                if($_GET['page_num']<0 or $_GET['page_num']>$all_pages)
                {
                    header("Location: edit_product.php?page_num=1&search=".$search);
                    mysqli_close();
                    exit();
                }
                else
                {

                    $page_num=$_GET['page_num'];
                }  
            else
            {
                header("Location: edit_product.php?page_num=1&search=".$search);
                mysqli_close();
                exit();
            }
                //$page_num=1;

            if($nav_limit>$all_pages)
                $nav_limit=$all_pages;

            if($page_num==1)
                $prev=1;
            elseif($page_num>1)
                $prev=$page_num-1;


            if($page_num<$all_pages)
                $next=$page_num+1;
            else
                $next=$all_pages;

            $limit = ($page_num - 1) * $on_page;
            ////

            $products=mysqli_query($link,"SELECT z.link,p.nazwa,p.idProduktu,p.ilosc,p.cena,levenshtein(LOWER(p.nazwa),LOWER('$search')) AS distance FROM Produkty p LEFT JOIN Zdjecia z ON z.idProduktu=p.idProduktu WHERE levenshtein(LOWER(p.nazwa),LOWER('$search')) < 3 ORDER BY distance ASC;");

            $order_id=0;
            while($row=mysqli_fetch_assoc($products))
            {
                if(empty($row['link']))
                    $row['link']="products_images/tablets.png";

                $products_data.='<div class="col-sm-4 product">
                <div class="product_background">
                        <h3><a class="product_a" href="product.php?id='.$row['idProduktu'].'">Więcej informacji</a></h3>
                        <div id="qi'.$order_id.'" style="color:white">Dostępnych: '.$row['ilosc'].'.</div>
                        <div style="color:white">Cena: '.$row['cena'].' zł/szt</div>

                    
                    <div >
                        <form method="post" action="edit_product_panel.php"><button type="submit" class="product_button" value="'.$row['idProduktu'].'" name="edit_button" >Edytuj</button><br><br><button type="button" class="product_button delete_button" value="'.$row['idProduktu'].'" >Usuń</button></form>
                    </div> 
                    
                </div>
                <img src="'.$row['link'].'" class="img-responsive" alt="zdjęcie produktu" style="width:100%;">
                <h4 style="color:white">'.$row['nazwa'].'</h4>
                </div>
                ';
                
                //<span style="color:white">Dostępnych: '.$row['ilosc'].' szt.<br>Cena: '.$row['cena'].' zł/szt</span>
                    /*$products_data=$products_data.'<div class="product product_big"><div class="product_background"><h4 style="color:white"><a class="product_a" href="produkt.php?id='.$row['idProduktu'].'">Więcej informacji</a></h4><form method="post" action="edit_product_panel.php"><button type="submit" class="product_button" value="'.$row['idProduktu'].'" name="edit_button" >Edytuj</button><br><br><button type="button" class="product_button" value="'.$row['idProduktu'].'" id="delete_button">Usuń</button></form></div><img src="products_images/tablets.png" alt="Zdjęcie produktu" style="width:100%;"><span>'.$row['nazwa'].'</span></div>';*/
            }

            $forstart = $page_num - floor($nav_limit/2);

            if($forstart <= 0){ $forstart = 1; }

            $forend = $forstart + $nav_limit;
            if($forend>$all_pages)
                $forend=$all_pages;

            $pagination_bar='<ul class="pagination"><li><a href="edit_product.php?page_num='.$prev.'&search='.$search.'">&laquo;</a></li>';

            for($forstart;$forstart<=$forend;$forstart++)
            {

                if($forstart==$page_num)
                    $pagination_bar.='<li><a class="active" href="edit_product.php?page_num='.$forstart.'&search='.$search.'">'.$forstart.'</a></li>';
                else
                    $pagination_bar.='<li><a href="edit_product.php?page_num='.$forstart.'&search='.$search.'">'.$forstart.'</a></li>';
            }

            $pagination_bar.='<li><a href="edit_product.php?page_num='.$next.'&search='.$search.'">&raquo;</a></li></ul>';
        }
        else
        {
            $products_data="<h1 style=\"text-align:center;color:white\">BRAK WYNIKÓW WYSZUKIWANIA</h1>";
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
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(isset($answer)) echo $answer; ?></h1></div>
    <div id="admin_answer2" style="color:#8af294;text-align:center;"><h1><?php if(isset($answer2)) echo $answer2; ?><h1></div>
    <div id="admin_panel">
        <div class="add_panel" style="color:white">
        <h2 style="color:white">Edycja produktu</h2>
            
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-3">
                    <input id="search" class="form-control in" type="text" placeholder="Nazwa produktu" name="search" required pattern=".{1,50}" title="1-50 znaków">
                </div>
                <div class="col-sm-2" style="margin-top:-6px;"><button class="btn btn-success btn-lg" type="submit">Szukaj</button></div>
            </div>
            
        </form>
        </div>
        <div >
            <?php
                if(isset($products_data))
                    echo $products_data;
            ?>
        </div>
    </div>   
    </div> 
</div>

</body>
<script>
$(document).ready(function(){
    
    
    $('.delete_button').on('click',function() {
        
        var x=confirm("Czy napewno chcesz usunąć ten produkt?");
        
        if(x==false)
            return; 
        
        try
        {
            var xhttp;

            if(!$(this))
                    throw "Brak elementów html";
            
            var product_id=$(this).val();

            if (window.XMLHttpRequest) 
            {
                xhttp = new XMLHttpRequest();
            } 
            else 
            {
                xhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText=="not ok")
                {
                    product_purchased("Nie można usunąć produktu");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else
                {
                    setTimeout(function() {
                       document.location.reload(true); 
                    }, 2500);
                    
                    /*window.location="edit_product.php";*/
                    console.log("Usunięto produkt");
                    product_purchased("Usunięto produkt");
                }

            }
            };
            xhttp.open("POST", "delete_product.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("product_id="+product_id);
        }
        catch(err)
        {
            alert("Błąd, operacja została przerwana");
        }
    });
});
</script>
</html>