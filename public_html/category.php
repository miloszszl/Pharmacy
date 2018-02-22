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
foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

$categories_q=mysqli_query($link,"SELECT * FROM Kategorie;");
if($categories_q)
{
    $categories_data="";
    while($row=mysqli_fetch_assoc($categories_q))
    {
        $categories_data.="<li><a href=\"category.php?category_id={$row['idKategorii']}\">{$row['nazwa']}</a></li>";
    }
}

if(isset($_GET['category_id']))
{
    $category_id = test_input($_GET['category_id'],$link);

    $all_products=mysqli_query($link,"SELECT count(*) cnt FROM Produkty WHERE idKategorii=$category_id");

    if($all_products)
    {

        if(!isset($_GET['sort_opt']))
                $sort_opt="default";
            else
                $sort_opt= $_GET['sort_opt'];

            $default_selected=$name_asc_selected=$name_desc_selected=$price_desc_selected=$price_asc_selected="";
            switch($sort_opt)
            {
                case "default":
                    $sort_q="ORDER BY idProduktu";
                    $default_selected="selected";
                    break;
                case "name_asc":
                    $sort_q="ORDER BY LOWER(nazwa) ASC";
                    $name_asc_selected="selected";
                    break;
                case "name_desc":
                    $sort_q="ORDER BY LOWER(nazwa) DESC";
                    $name_desc_selected="selected";
                    break;
                case "price_desc":
                    $sort_q="ORDER BY cena DESC";
                    $price_desc_selected="selected";
                    break;
                case "price_asc":
                    $sort_q="ORDER BY cena ASC";
                    $price_asc_selected="selected";
                    break;
                default:
                    header('Location: index.php');
                    mysqli_close($link);
                    exit();
            }


        $all_products=mysqli_fetch_assoc($all_products);
        if($all_products['cnt']>0)
        {   
            $all_products=$all_products['cnt'];
            $on_page = 6; //ilość leków na stronie
            $nav_limit= 5; //ilość wyświetlanych numerów stron
            $all_pages=ceil($all_products/$on_page);
            //echo $all_pages;
            if(isset($_GET['page_num']) and is_numeric($_GET['page_num']) and $_GET['page_num']>0 and $_GET['page_num']<=$all_pages)
                $page_num=$_GET['page_num'];
            else
                $page_num=1;

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



            $products=mysqli_query($link,"SELECT p.nazwa,p.idProduktu,p.ilosc,p.cena,z.link FROM Produkty p LEFT JOIN Zdjecia z ON z.idProduktu=p.idProduktu WHERE idKategorii=$category_id $sort_q LIMIT $limit, $on_page;");

            $products_data="";
            /*$my_data="";*/
            if(mysqli_num_rows($products)>0)
            {
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
                        <input id="h'.$order_id.'" type="hidden" value="'.$row['idProduktu'].'">
                        <div  style="min-width:80px;max-width:180px;margin-left:auto;margin-right:auto;">
                            <input class="form-control in" type="text" value=1 class="product_input" id="i'.$order_id.'">

                        </div>
                        <div >
                            <button type="button" class="btn btn-success btn-sm" style="margin-top:3px;" class="product_button" id="b'.$order_id++.'" onclick="basket(this.id)">Do koszyka</button>
                        </div>  
                    </div>
                    <img src="'.$row['link'].'" class="img-responsive" alt="zdjęcie produktu" style="width:100%;">
                    <h4>'.$row['nazwa'].'</h4>
                    </div>
                    ';
                    
                    
                    
                    
                    /*$products_data=$products_data.'<div class="product"><div class="product_background"><h2 style="color:white"><a class="product_a" href="product.php?id='.$row['idProduktu'].'">Więcej informacji</a></h2><span id="qi'.$order_id.'" style="color:white">Dostępnych: '.$row['ilosc'].' szt.</span><br><span style="color:white">Cena: '.$row['cena'].' zł/szt</span><div class="buy_inputs"><input type="text" value=1 class="product_input" id="i'.$order_id.'"><input id="h'.$order_id.'" type="hidden" value="'.$row['idProduktu'].'"><button type="button" class="product_button" id="b'.$order_id++.'" onclick="basket(this.id)">Do koszyka</button></div></div><img src="products_images/tablets.png" alt="zdjęcie produktu" style="width:100%;"><span>'.$row['nazwa'].'</span></div>';*/
                }
            }
            else
            {
                $products_data="<h1 style=\"text-align:center\">Brak produktów w wybranej kategorii<h1>";
            }

            $forstart = $page_num - floor($nav_limit/2);

            if($forstart <= 0){ $forstart = 1; }

            $forend = $forstart + $nav_limit;
            if($forend>$all_pages)
                $forend=$all_pages;

            $pagination_bar='<ul class="pagination"><li><a href="category.php?page_num='.$prev.'&category_id='.$category_id.'&sort_opt='.$sort_opt.'">&laquo;</a></li>';
            for($forstart;$forstart<=$forend;$forstart++)
            {

                if($forstart==$page_num)
                    $pagination_bar.='<li><a class="active" href="category.php?page_num='.$forstart.'&category_id='.$category_id.'&sort_opt='.$sort_opt.'">'.$forstart.'</a></li>';
                else
                    $pagination_bar.='<li><a href="category.php?page_num='.$forstart.'&category_id='.$category_id.'&sort_opt='.$sort_opt.'">'.$forstart.'</a></li>';
            }

            $pagination_bar.='<li><a href="category.php?page_num='.$next.'&category_id='.$category_id.'&sort_opt='.$sort_opt.'">&raquo;</a></li></ul>';
        }
        else
        {
            $products_data="<h1 style=\"text-align:center\">Brak produktów w wybranej kategorii<h1>";
            $pagination_bar="";
        }
    }
    else
    {
        $products_data="<h1 style=\"text-align:center\">Brak produktów w wybranej kategorii<h1>";
    }
}
mysqli_close($link); 

?>

<!DOCTYPE html>
<head lang="pl">
    <title>M Apteka</title>
    <meta charset="UTF-8">
    <meta name="description" content="Skep z asortymentem medycznym.Odwiedz nas i bądź zdrowy jak ryba.">
    <link rel="shortcut icon" href="images/pill.png" />
    <meta name="keywords" content="Apteka,pharmacy,leki,chemia,bandaż,syrop,tabletki,choroby,przeziebienie">
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
<div id="cover"></div>
<div class="container-fluid">    
<div class="row">
<div class="col-sm-2 menu_bar" style="position:fixed;padding:0;">
    <a href="index.php" id="a_logo">
        <div class="logo">
            <img class="img_logo" src="images/rsz_logo.png" alt="Logo Apteki"><br/>
                M Apteka
        </div>
    </a>

    <div class="menu_options">
        <a href="index.php" style="color:white; text-decoration:none;"><span data-title="Strona główna"><div class="icon-home-outline menu_option" id="home"></div></span></a>
        <span data-title="Twoje Konto"><a href="user.php" style="color:white; text-decoration:none;"><div class="icon-user-o menu_option" id="user" ></div></a></span>
        <span data-title="Koszyk"><a href="user_basket.php" style="color:white; text-decoration:none;"><div class="icon-cart-plus menu_option"></div></a></span>
        <span data-title="Kontakt"><a href="contact_us.php" style="color:white; text-decoration:none;"><div class="icon-mail menu_option" id="contact"></div></a></span>
    </div>
</div>

<div class="col-sm-10 col-sm-offset-2" >
<!--<div class="right_side">-->
    <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript> 
    <div class="row search_bar">
        <div class="col-sm-3" style="padding:20px">
            <?php
                if(!empty($admin_button)) echo $admin_button;
            ?>
        </div>
        <div class="col-sm-6">
            <form method="POST" autocomplete="off" action="search.php">
                <input class="search_input" name="search_input" type="text" name="search" placeholder="Szukaj" >
            </form>
        </div>
        <div class="col-sm-3" style="padding-top:20px;">
            <form action="logout.php" class="form-group" method="POST">
                <?php
                    if(!empty($logout_button)) echo $logout_button;
                ?>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="cos-sm-12 " style="margin:20px;">
            <div id="sort_div">
                SORTOWANIE: 
                <select id="sort_select"  onchange="sort(this)">
                    <option value="default" <?php if(isset($default_selected)) echo $default_selected; ?>>DOMYŚLNE</option>
                    <option value="name_asc" <?php if(isset($name_asc_selected)) echo $name_asc_selected; ?>>NAZWA A-Z</option>
                    <option value="name_desc" <?php if(isset($name_desc_selected)) echo $name_desc_selected; ?>>NAZWA Z-A</option>
                    <option value="price_desc" <?php if(isset($price_desc_selected)) echo $price_desc_selected; ?>>CENA malejąco</option>
                    <option value="price_asc" <?php if(isset($price_asc_selected)) echo $price_asc_selected; ?>>CENA rosnąco</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row categories" >
        <ul class="cat_inscription">
            <?php if(!empty($categories_data)) echo $categories_data;?>
            <span style="clear:both"></span>
        </ul>
    </div>
    <div class="row products">
            <div class="products">
            <?php
                if(isset($products_data)) echo $products_data;
            ?>
        </div>
        
    </div>
    <div class="row ">
        <div class="pagination_div">
            <?php if(isset($pagination_bar)) echo $pagination_bar; ?>
        </div>
    </div>
</div>
</div>
</div> 

<script>

    function sort(element)
    {
        try
        {
            if(element)
                if(element.value)
                    window.location.href="category.php?sort_opt="+element.value+"&category_id="+<?php echo $category_id; ?>;
        }
        catch(err)
        {
            alert("Błąd, operacja została przerwana");
        }
    }
    
  function basket(button_id)
    {
        
        var xhttp;
        
        try
        {
            var id=button_id.substr(1);
            var product_quantity=$("#i"+id);
            var product_id=$("#h"+id);

            var product_quantity_info=$("#qi"+id);
        
        
            if(!product_quantity || !product_id || !id || !product_quantity_info)
                throw "Brak elementów html";
            
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
                    product_purchased("Nie możesz dodać produktu do koszyka");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else if(this.responseText=='Problem z połączeniem z bazą danych')
                {
                    product_purchased('Problem z połączeniem z bazą danych');
                }
                else
                {
                    product_quantity_info.text("Dostępnych: "+this.responseText+" szt.");  
                    product_purchased("Dodano produkt do koszyka");
                }
            }
            };
            xhttp.open("POST", "insert_to_basket.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("product_id="+product_id.val()+"&"+"product_quantity="+product_quantity.val());
        }
        catch(err)
        {
            alert("Błąd, operacja została przerwana");
        }
    }
    
    
    
    
$(document).ready(function()
{       
    if(document.cookie.indexOf("show_logout_info") >= 0)
    {
        document.cookie = 'show_logout_info=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        $('body').append('<div id="my_alert">Wylogowano pomyslnie<br><button id="alert_button" type="button">OK</button></div>');
        $("#cover").css('display','block'); 
        
        $(document).on('click','#alert_button',function(){
            $("#cover").css('display','none');
            $('#my_alert').remove();
        });
    }
});

</script>   
</body>
</html>