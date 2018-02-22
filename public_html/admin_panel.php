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

if(!($admin && $loged_in))
{
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<head lang="pl">
    <title>Panel Admina</title>
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
    <div class="col-sm-1"></div>
    <div class="col-sm-5 admin_menu1">
        <a href="add_product.php" class="white_a"><div id="add_pr" class="admin_menu_option"><div class="icon-plus-squared col1"></div><div class="col2">Dodaj produkt</div></div></a>
        <a href="edit_product.php" class="white_a"><div class="admin_menu_option"><div class="icon-pencil-squared col1"></div><div class="col2">Edytuj produkt</div></div></a>


        <a href="add_brand.php" class="white_a"><div class="admin_menu_option"><div class="icon-plus-circled col1"></div><div class="col2">Dodaj markę</div></div></a>
        <a href="edit_brand.php" class="white_a"><div class="admin_menu_option"><div class="icon-vector-pencil col1"></div><div class="col2">Edytuj markę</div></div></a>

        <a href="edit_user.php" class="white_a"><div class="admin_menu_option"><div class="icon-user-circle col1"></div><div class="col2">Edytuj użytkownika</div></div></a>
    </div>
    <div class="col-sm-5">
        <a href="add_category.php" class="white_a"><div id="add_category" class="admin_menu_option"><div class="icon-plus-squared-alt col1"></div><div class="col2">Dodaj kategorię</div></div></a>
        <a href="edit_categories.php" class="white_a"><div class="admin_menu_option"><div class="icon-edit col1"></div><div class="col2">Edytuj kategorię</div></div></a>

        <a href="add_delivery.php" class="white_a"><div class="admin_menu_option"><div class="icon-plus col1"></div><div class="col2">Dodaj dostawcę</div></div></a>
        <a href="edit_delivery.php" class="white_a"><div class="admin_menu_option"><div class="icon-pencil col1"></div><div class="col2">Edytuj dostawcę</div></div></a>

        <a href="orders_admin.php" class="white_a"><div class="admin_menu_option"><div class="icon-shopping-basket col1"></div><div class="col2">Pokaż zamówienia</div></div></a>
    </div>
    <div class="col-sm-1"></div>
    </div>
    
</div>

</body>
</html>