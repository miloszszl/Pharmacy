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

if(!$loged_in)
    header("Location: login.php");
else
{
    if(!empty($_POST['detail_button']))
    {
        try
        {
            mysqli_query($link,"SET CHARSET utf8;");
            mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

            $_COOKIE['id']=test_input($_COOKIE['id'],$link);
            $u_q=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
            if(!$u_q)
                throw new Exception();

            mysqli_data_seek($u_q,0);
            $user_id_assoc=mysqli_fetch_assoc($u_q);
            mysqli_free_result($u_q);
            mysqli_next_result($link);

            $user_id=$user_id_assoc['idUzytkownika'];

            $order_id=test_input($_POST['detail_button'],$link);

            $orders_q=mysqli_query($link,"SELECT z.dataZamowienia,z.idStatusuZamowienia,d.cena FROM Zamowienia z JOIN Dostawcy d ON d.idDostawcy=z.idDostawcy WHERE z.idUzytkownika=$user_id AND z.idZamowienia=$order_id;");

            if(!$orders_q)
                throw new Exception();

            $answer="";
            if(mysqli_num_rows($orders_q)>0)
            {
                $orders_assoc=mysqli_fetch_assoc($orders_q);
                $order_status=$orders_assoc['idStatusuZamowienia'];
                $delivery_price=$orders_assoc['cena'];

                $products_q=mysqli_query($link,"SELECT p.nazwa,pz.cenaZamowieniowa,pz.ilosc FROM Produkty p JOIN ProduktyZamowienia pz ON pz.idProduktu=p.idProduktu JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia WHERE z.idZamowienia=$order_id AND z.idUzytkownika=$user_id;");

                if(!$products_q)
                    throw new Exception();

                if(mysqli_num_rows($products_q)>0)
                {
                    $products_data="";
                    $sum=0;
                    while($row=mysqli_fetch_assoc($products_q))
                    {
                        $price=$row['cenaZamowieniowa']*$row['ilosc'];
                        $sum+=$price;

                        $products_data.="<div class=\"tr\" method=\"POST\" action=\"user_specified_order.php\"><span class=\"td\">{$row['nazwa']}</span><span class=\"td\">{$row['ilosc']}</span><span class=\"td\">".number_format($row['cenaZamowieniowa'], 2, '.', '')." zł</span><span class=\"td\">".number_format($price, 2, '.', '')." zł</span></div>";
                    }
                    $sum+=$delivery_price;
                }
                else
                {
                    $error_answer="Nie ma takiego zamówienia";
                }

                if($order_status==1)
                {
                    $cancel_form="<form style='display:inline;' method=\"POST\" action=\"cancel_user_order.php\"><button style=\"width:300px;\" name=\"cancel_button\" value=\"$order_id\" class=\"btn btn-success btn-lg\" type=\"submit\">Anuluj zamówienie</button></form>";
                }
            }
            else
            {
                $error_answer="Nie ma takiego zamówienia";
            }
        }
        catch(Exception $e)
        {
            $error_answer="Błąd <br>Operacja została zatrzymana";
        }
        
    }
    else
    {
        $error_answer="Nie ma takiego zamówienia";
    }
}
mysqli_close($link);  

?>

<!DOCTYPE html>
<head lang="pl">
    <title>Twoje konto</title>
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
                    <form action="logout.php" method="POST">
                        <?php
                            if(!empty($logout_button)) echo $logout_button;
                        ?>
                    </form>
                </div>
            </div>
            <div class="row user_account_container">
                <ul class="nav nav-justified">
                    <li class="dropdown" >
                        <a class="dropdown-toggle white_a hov" style="font-size:20px;" data-toggle="dropdown" href="#"><b>Moje konto</b>
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="font-size:22px;">
                            <li><a class="white_a hov"  href="change_password.php" >Zmień hasło</a></li>
                            <li><a class="white_a hov" href="account_data.php" >Dane konta</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle white_a hov" style="font-size:20px;" data-toggle="dropdown" href="#"><b>Zamówienia</b>
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="font-size:22px;">
                            <li><a class="white_a hov" href="user_orders.php?order_status=1" >Niezrealizowane</a></li>
                            <li><a class="white_a hov" href="user_orders.php?order_status=2" >Zrealizowane</a></li>
                            <li><a class="white_a hov" href="user_orders.php?order_status=3" >Anulowane</a></li>
                        </ul>
                    </li>
                    <li><a href="service_and_complaint.php" class=" white_a hov" style="font-size:20px;"><b>Serwis i reklamacje</b></a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10 user_greeting_panel" >

                    <h2>Zamówienie<?php if(!empty($orders_assoc) and $orders_q)  echo " z dnia: $orders_assoc[dataZamowienia]"; ?></h2>
                    <div style="overflow-x:auto;">
                    <div class="table center" style="overflow-x:auto;">
                        <div class="tr">
                            <span class="th">Nazwa</span>
                            <span class="th">Liczba sztuk</span>
                            <span class="th">Cena za sztukę</span>
                            <span class="th">Suma</span>
                        </div>
                       <?php  if(!empty($products_data)) echo $products_data; ?>
                    </div>

                    <?php 
                        if(isset($error_answer)) echo "<h3 style=\"color:orange\">$error_answer</h3>";
                        if(isset($delivery_price)) echo "<br><b>Koszt dostawy:".number_format($delivery_price, 2, '.', '')." zł</b><br>";
                        if(isset($sum)) echo "<b>Całkowity koszt zamówienia:".number_format($sum, 2, '.', '')." zł</b><br>"; 
                    ?>
                    <div>
                        <?php if(isset($cancel_form)) echo $cancel_form; ?>
                        <button type="button" onClick="javascript:window:location.href='user.php';" class="btn btn-success btn-lg">Powrót</button>
                    </div>
                    </div>

                </div>
            </div> 
        </div>
    </div>
</div> 
<div style="clear:both;"></div>
</body>
</html>