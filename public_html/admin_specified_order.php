<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";
require_once "my_functions.php";
$answer="";
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
    if(isset($_GET['delete_button']))
    {
        $val=test_input($_GET['delete_button'],$link);//<h1 style=\"color:#8af294\" >
        
        $q=mysqli_query($link,"DELETE FROM Zamowienia WHERE idZamowienia=$val;");
        
        if($q)
            if(mysqli_affected_rows($link)>0)
            {
                $answer="Usunieto zamówienie o id=$val";
            }
            else
            {
                $answer="Nie istnieje zamówienie o id=$val";
            }
        else
           $answer="Nie istnieje takie zamówienie";

        header("Location: orders_admin.php?answer=".$answer);
        exit();
    }
    elseif(isset($_GET['detail_button']) or isset($_GET['order_id']))
    {
        if(isset($_GET['detail_button']))
            $order_id=test_input($_GET['detail_button'],$link);
        elseif(isset($_GET['order_id']))
            $order_id=test_input($_GET['order_id'],$link);

        $answer="";

        $products_q=mysqli_query($link,"SELECT concat(m.nazwa,' ',u.nazwaUlicy,' ',u.numerDomu) as adres, d.cena dc,d.nazwa dn, u.login,z.dataZamowienia,z.uwaga,st.idStatusuZamowienia,st.nazwaStatusuZamowienia, p.nazwa,pz.cenaZamowieniowa  pc,pz.ilosc FROM Produkty p JOIN ProduktyZamowienia pz ON pz.idProduktu=p.idProduktu JOIN Zamowienia z ON z.idZamowienia=pz.idZamowienia JOIN StatusyZamowien st ON st.idStatusuZamowienia=z.idStatusuZamowienia JOIN Uzytkownicy u ON u.idUzytkownika=z.idUzytkownika JOIN Dostawcy d ON d.idDostawcy=z.idDostawcy JOIN Miasta m ON m.idMiasta=u.idMiasta WHERE z.idZamowienia=$order_id AND z.dataZamowienia IS NOT NULL;");

        if(!mysqli_error($link))
        {
            if(mysqli_num_rows($products_q)>0)
            {
                $products_data="";
                $sum=0;
                $delivery_price=0;

                $delivery_flag=true;
                $login_flag=true;
                $order_date_flag=true;
                $order_state_flag=true;
                $desc_flag=true;
                $delivery_name_flag=true;
                $address_flag=true;

                while($row=mysqli_fetch_assoc($products_q))
                {
                    if($delivery_flag==true)
                    {
                        $delivery_flag=false;
                        $delivery_price=$row['dc'];
                    }

                    if($address_flag==true)
                    {
                        $address_flag=false;
                        $address=$row['adres'];
                    }

                    if($login_flag==true)
                    {
                        $login_flag=false;
                        $login=$row['login'];
                    }

                    if($order_date_flag==true)
                    {
                        $order_date_flag=false;
                        $order_date=$row['dataZamowienia'];
                    }

                    if($order_state_flag==true)
                    {
                        $order_state_flag=false;
                        $order_state=$row['nazwaStatusuZamowienia'];
                        $order_state_id=$row['idStatusuZamowienia'];
                    }

                    if($desc_flag==true)
                    {
                        $desc_flag=false;
                        $user_note=$row['uwaga'];
                    }
                    if($delivery_name_flag==true)
                    {
                        $delivery_name_flag=false;
                        $delivery_name=$row['dn'];
                    }

                    $price=$row['pc']*$row['ilosc'];
                    $sum+=$price;

                    $products_data.="<div class=\"tr white_a\" method=\"POST\" action=\"user_specified_order.php\"><span class=\"td\">{$row['nazwa']}</span><span class=\"td\">{$row['ilosc']}</span><span class=\"td\">".number_format($row['pc'], 2, '.', '')." zł</span><span class=\"td\">".number_format($price, 2, '.', '')." zł</span></div>";
                }
                $sum+=$delivery_price;


                ///order status
                if(isset($order_state_id))
                {
                    $select_q=mysqli_query($link,"SELECT * FROM StatusyZamowien;");
                    $options="";
                    while($row=mysqli_fetch_assoc($select_q))
                    {
                        if($row['idStatusuZamowienia']==$order_state_id)
                            $options=$options."<option value=\"$row[idStatusuZamowienia]\" selected>".$row['nazwaStatusuZamowienia']."</option>";
                        else
                            $options=$options."<option value=\"$row[idStatusuZamowienia]\">".$row['nazwaStatusuZamowienia']."</option>";
                    }  
                }

                //end of order status

            }
            else
            {
                $error_answer="Nie ma takiego zamówienia";
            }
        }
        else
        {
            $error_answer="Błąd, operacja została przerwana";
        }
    }
    else
    {
        header("Location: admin_panel.php");
    }

    if(isset($_GET['answer']))
    {
        $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
        $answer=str_replace("\n","<br>",$answer,$i);

        if($answer=="Edycja przebiegła pomyślnie")
        {
            $answer="<span style=\"color:#8af294\">".$answer."</span>";
        }
    }
}
mysqli_close($link);

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
    
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(isset($answer)) echo $answer; ?></h1></div>
            <div id="admin_panel" style="color:white;" class="center_text">

                <h2>Zamówienie<?php if(isset($login) and isset($order_date))  echo " użytkownika: $login<br> z dnia: $order_date";?></h2>
                <br><br>
                <div style="overflow-x:auto;">
                    <div class="table center" >
                        <div class="tr white_a">
                            <span class="th admin_table_border">Nazwa produktu</span>
                            <span class="th admin_table_border">Liczba sztuk</span>
                            <span class="th admin_table_border">Cena za sztukę</span>
                            <span class="th admin_table_border">Suma</span>
                        </div>
                       <?php  if(!empty($products_data)) echo $products_data; ?>
                    </div>
                </div>
                <br><br>    
                <?php 
                    if(isset($error_answer)) echo "<h3 style=\"color:orange\">$error_answer</h3>";
                    if(isset($delivery_name)) echo "<br><b>Dostawca: $delivery_name</b>";
                    if(isset($delivery_price)) echo "<br><b>Koszt dostawy:".number_format($delivery_price, 2, '.', '')." zł</b><br>";
                    if(isset($sum)) echo "<b>Całkowity koszt zamówienia:".number_format($sum, 2, '.', '')." zł</b><br>"; 
                    if(isset($address)) echo "<b>Adres: $address</b><br><br><br>";
                    if(!empty($user_note)) echo "<h3>Uwaga od klienta: </h3><br>$user_note<br><br>";  
                ?>
                <br>
<?php
            if(isset($order_state_id))
            {
                echo "<b>Status Zamówienia: </b><br><br>
                <form method=\"POST\" action=\"order_state_change_execution.php\">
                    <div class=\"row\">
                        <div class=\"col-sm-3 col-sm-offset-4\">
                            <select name=\"order_status_id\" class=\"form-control in\">";
                                
                                    if(isset($options)) echo $options;  
                                
                        echo "</select>
                        </div>
                        <div class=\"col-sm-2\">
                            <button type=\"submit\" class=\"btn btn-success btn-lg\" style=\"margin-top:-6px;\" name=\"order_id\" value=\"";
                       
                        if(isset($order_id)) echo $order_id;
                    
                        echo "\">Zmień</button>
                        </div>
                    </div>
                </form>";
            }
?>
                <br><br>
                <div>
                    <?php if(isset($cancel_form)) echo $cancel_form; ?>
                    <button onClick="javascript:window:location.href='orders_admin.php';" type="button"  class="btn btn-success btn-lg">Powrót</button>
                </div>
                    
                
            </div>  
    
</div>
    

<script>

</script>
</body>
</html>