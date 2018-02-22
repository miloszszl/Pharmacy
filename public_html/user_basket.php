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


$link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());


if(!empty($_GET['answer']))
{
    $answer=test_input($_GET['answer'],$link);
}

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);

mysqli_query($link,"SET CHARSET utf8");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");


$basket_data="";
$delivery_options="";
$sum=0;

if($loged_in)
{
    $_COOKIE['id']=test_input($_COOKIE['id'],$link);
    $user_id=mysqli_query($link,"CALL take_user_id('$_COOKIE[id]');");
    if($user_id)
    {
        mysqli_data_seek($user_id,0);
        $user_id_assoc=mysqli_fetch_assoc($user_id);
        mysqli_free_result($user_id);
        mysqli_next_result($link);
        
        $basket_q=mysqli_query($link,"SELECT pz.idPrZam,p.nazwa,pz.cenaZamowieniowa,pz.ilosc FROM Produkty p JOIN ProduktyZamowienia pz ON pz.idProduktu=p.idProduktu JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia WHERE z.dataZamowienia IS NULL AND z.idUzytkownika=$user_id_assoc[idUzytkownika];");

        if($basket_q and mysqli_num_rows($basket_q)>0)
        {
            while($row=mysqli_fetch_assoc($basket_q))
            {
                $price=$row['cenaZamowieniowa']*$row['ilosc'];
                $sum+=$price;
                $basket_data.="<tr><td>{$row['nazwa']}</td><td>{$row['ilosc']}</td><td>".number_format($price, 2, '.', '')." zł</td><td><button class=\"btn btn-success btn-lg\" type=\"submit\" name=\"product_remove_button\" onclick=\"delete_row(this)\" value=\"{$row['idPrZam']}\" data-price=\"{$row['cenaZamowieniowa']}\">Usuń</button></td></tr>";
            }

            $select_q=mysqli_query($link,"SELECT * FROM Dostawcy;");

            if($select_q)
                while($row=mysqli_fetch_assoc($select_q))
                {
                    $delivery_options.="<option value=\"{$row['idDostawcy']}\" data-price=\"{$row['cena']}\">".$row['nazwa']."  ".$row['cena']." zł</option>";    
                }
        }
    }
}
else
{
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<head lang="pl">
    <title>Twoje konto</title>
    <meta charset="UTF-8">
    <meta name="description" content="Skep z asortymentem medycznym.Odwiedź nas i bądź zdrowy jak ryba.">
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
                <div class="col-sm-10 user_greeting_panel" style="font-size:18px;">

                    <div id="answer_box"></div>
                    <h2>Twój koszyk</h2>
                    <div id="empty_basket_answer" style="color:red"><?php if(!empty($answer)) echo $answer;?></div>
                    <br>
                    <div id="order_content">
                        <div style="overflow-x:auto;">
                        <?php

                            if(!empty($basket_data) and $basket_data!="")
                            {
                                //table
                                echo "<table class=\"table table-hover\" >
                                    <tr>
                                        <th style=\"text-align:center\">Nazwa produktu</th>
                                        <th style=\"text-align:center\">Liczba sztuk</th>
                                        <th style=\"text-align:center\">Cena całkowita</th>
                                        <th style=\"text-align:center\">Usuwanie</th>
                                    </tr>
                                    $basket_data   
                                </table><br></div>";
                                //table end
                                echo "<form action=\"order.php\" method=\"POST\">";
                                echo "Wybierz opcję dostawy: <select class=\"form-control col-sm-4 in\" id=\"select_delivery\" name=\"delivery\" onchange=\"price(this)\">";
                                if(!empty($delivery_options)) echo $delivery_options;  
                                echo "</select><br><br>";

                                echo "Całkowity koszt: <strong><span id=\"price_box\">".number_format($sum, 2, '.', '')." zł</span></strong><br><br>"; 

                                echo "Dodatkowa wiadomość dla sprzedającego:<br>";
                                echo "<textarea id=\"order_message\" maxlength=\"500\" placeholder=\"Twoja wiadomość (do 500 znaków)\" name=\"order_message\" cols=\"40\" rows=\"5\" ></textarea><br><br>";

                                echo '<button type="submit" class="btn btn-success btn-lg" name="order_button" >Zamów</button>';
                                echo "</form>";
                            }
                            else
                            {
                                echo "<span style=\"color:red\">Aktualnie Twój koszyk jest pusty</span>";
                            }
                        ?>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
    </div>
</div> 

<div style="clear:both;"></div>

<script>
var last_delivery_price=0;  

    
function price(element)
{   
    try
    {
        if(element!=null)
        if(element.options[element.selectedIndex]!=null)
        {
            var delivery_price=element.options[element.selectedIndex].getAttribute('data-price');
            var price_box=document.getElementById('price_box');
            price_box.innerHTML=(parseFloat(price_box.innerHTML)+parseFloat(delivery_price)-parseFloat(last_delivery_price)).toFixed(2)+" zł";
            last_delivery_price=delivery_price;
        }
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana");
    }
}

function select_default()
{
    try
    {
        var option=document.getElementById("select_delivery");
        price(option);
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana");
    }
}
    
select_default();

function delete_row(btn)
{
    try
    {
        var xhttp;
        
        
        var answerBox=$("#answer_box");
        var empty_basket_info=$("#empty_basket_answer");
        var order_data=$("#order_content");
        if(!btn || !answerBox || !empty_basket_info || !order_data)
            throw "error";
        
        var id_przam=btn.value;
        
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
                answerBox.text("Nie możesz usunąć produktu z koszyka");
            }
            else if(this.responseText=="redirect")
            {
                window.location="login.php";
            }
            else if(this.responseText=="ok")
            {
                answerBox.text("Usunięto produkt z koszyka");
                var product_price=btn.getAttribute('data-price');
                var price_box=document.getElementById('price_box');
                
                price_box.innerHTML=(parseFloat(price_box.innerHTML)-parseFloat(product_price)).toFixed(2)+" zł";
                
            }
            else if(this.responseText=="no more results")
            {
                answerBox.text("Usunięto produkt z koszyka");
                empty_basket_info.text("Aktualnie twój koszyk jest pusty");
                order_data.text("");
            }
            else
            {
                answerBox.text("Błąd wewnętrzny"+this.responseText);
            }

        }
        };
        xhttp.open("POST", "remove_product_from_basket.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id_przam="+id_przam);

        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);  
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