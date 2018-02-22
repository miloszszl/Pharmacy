<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

function startsWith($sentence, $part_of_sentence)
{
     $length = strlen($part_of_sentence);
     return (substr($sentence, 0, $length) == $part_of_sentence);
}

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
    if(isset($_GET['answer']))
    {
        $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
        $answer=str_replace('\n',"<br>",$answer,$i);

        if(startsWith($answer, "Usunieto zamówienie o id="))
        {
            $answer="<span style=\"color:#8af294\">".$answer."</span>";
        }
    }
  
        $orders_statuses_q=mysqli_query($link,"SELECT * FROM StatusyZamowien;");
        if(mysqli_num_rows($orders_statuses_q)>0)
        {

            $orders_stat="<nav class=\"navbar navbar-inverse\"><ul class=\"nav navbar-nav\"><li><a href=\"orders_admin.php?order_status=-1&page_num=1\">WSZYSTKIE</a>";
            while($row=mysqli_fetch_assoc($orders_statuses_q))
            {
                $orders_stat.="<li><a href=\"orders_admin.php?order_status=$row[idStatusuZamowienia]&page_num=1\">".strtoupper($row['nazwaStatusuZamowienia'])."</a>";
            }
            $orders_stat.="</ul></nav>";
        }
        
        if(isset($_GET['order_status']))
        {   
            $order_status=test_input($_GET['order_status'],$link);
            
            switch($order_status)
            {
                case -1:$title="Wszystkie zamówienia";break;
                case 1:$title="Zamówienia w trakcie realizacji";break;
                case 2:$title="Zrealizowane zamówienia";break;
                case 3:$title="Anulowane zamówienia";break;
            }
            
            $order_status_part="";
            
            if($order_status!=-1)
                $order_status_part="AND z.idStatusuZamowienia=$order_status";
            
            $user_login_part="";
            if(isset($_GET['user_login_input']))
            { 
                $login=test_input($_GET['user_login_input'],$link);
                
                $user_login_part=" AND LOWER(login)=LOWER('$login')";
            }
             
            $if_part=$order_status_part.$user_login_part;
            
            $orders_q=mysqli_query($link,"SELECT z.idZamowienia,z.dataZamowienia,u.login FROM Zamowienia z JOIN Uzytkownicy u ON u.idUzytkownika=z.idUzytkownika WHERE z.dataZamowienia IS NOT NULL $if_part ORDER BY z.dataZamowienia ASC;");

            $orders_data="";
            if($orders_q and mysqli_num_rows($orders_q)>0)
            {
                $ordedrs_count=mysqli_num_rows($orders_q);
            /////////////////////////////////////////////////////////////////////////////               
                $all_orders=$ordedrs_count;
                $on_page = 10; //ilość zamowien na stronie
                $nav_limit= 5; //ilość wyświetlanych numerów stron
                $all_pages=ceil($all_orders/$on_page);

                if(isset($_GET['page_num']) and is_numeric($_GET['page_num']) and $_GET['page_num']>0 and $_GET['page_num']<=$all_pages)
                    $page_num=test_input($_GET['page_num'],$link);
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

                
                while($row=mysqli_fetch_assoc($orders_q))
                {
                    $orders_data.="<form class=\"tr white_a\" method=\"GET\" onsubmit=\"return check_if_sure(this.submited);\" action=\"admin_specified_order.php\"><span class=\"td\">{$row['dataZamowienia']}</span><span class=\"td\">{$row['login']}</span><span class=\"td\"><button type=\"submit\" class=\"btn btn-success btn-lg\" name=\"detail_button\" value=\"{$row['idZamowienia']}\" onclick=\"this.form.submited=this;\" >Szczegóły</button></span><span class=\"td\"><button type=\"submit\" class=\"btn btn-success btn-lg\" name=\"delete_button\" value=\"{$row['idZamowienia']}\" onclick=\"this.form.submited=this;\">Usuń</button></span></form>";
                }
                
                if($order_status==3)
                {
                    if(isset($_GET['canceled']))
                    {
                        $canceled=test_input($_GET['canceled'],$link);
                        
                        if($canceled==true)
                            $add_canceled_order_message="Zamówienie zostało anulowane";
                    }
                }
                
                $forstart = $page_num - floor($nav_limit/2);
        
                if($forstart <= 0){ $forstart = 1; }

                $forend = $forstart + $nav_limit;
                if($forend>$all_pages)
                    $forend=$all_pages;
                
                $user_login_part="";
                if(isset($user_id))
                {
                    $user_login_part="&user_login_input=".$_GET['user_login_input'];
                }
                
                $pagination_bar='<ul class="pagination"><li><a style="color:black" href="orders_admin.php?order_status='.$order_status.'&page_num='.$prev.$user_login_part.'">&laquo;</a></li>';
                for($forstart;$forstart<=$forend;$forstart++)
                {

                    if($forstart==$page_num)
                        $pagination_bar.='<li><a class="active" href="orders_admin.php?order_status='.$order_status.'&page_num='.$forstart.$user_login_part.'">'.$forstart.'</a></li>';
                    else
                        $pagination_bar.='<li><a href="orders_admin.php?order_status='.$order_status.'&page_num='.$forstart.$user_login_part.'">'.$forstart.'</a></li>';
                }

                $pagination_bar.='<li><a style="color:black" href="orders_admin.php?order_status='.$order_status.'&page_num='.$next.$user_login_part.'">&raquo;</a></li></ul>';
                
                ////////////////////////////////////////////////////////////////////////////
            }
            else
            {
                $orders_data="Brak zamówień";
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
    
    
        <?php if(isset($orders_stat)) echo $orders_stat ?>
      <h2 style="text-align:center;color:white;"><?php if(isset($title)) echo $title; else echo "Zamowienia"?></h2>
    <div id="admin_panel">
                
                
                <?php 
                    if(isset($orders_data))
                    {
                        if($orders_data=="Brak zamówień") 
                            echo "<h3 style=\"color:orange;text-align:center\">$orders_data</h3>";
                        else
                        {
                            echo "<form method=\"GET\" action=\"\" class=\"center_text\">
                                <input type=\"hidden\" value=\"";if(isset($_GET['page_num'])) echo $_GET['page_num']; echo "\" name=\"page_num\">
                                <input type=\"hidden\" value=\"";if(isset($_GET['page_num'])) echo $_GET['order_status']; echo "\" name=\"order_status\">
                                <div class=\"row\">
                                    <div class=\"col-sm-4 col-sm-offset-3\">
                                    <input type=\"text\" class=\"form-control in\" placeholder=\"login użytkownika\" name=\"user_login_input\">
                                    </div>
                                    <div class=\"col-sm-2\">
                                        <button type=\"submit\" style=\"margin-top:-6px;\" id=\"user_search_button\" class=\"btn btn-success btn-lg\" >Szukaj</button>
                                    </div>
                                </div>
                            </form>
                            <br><br>
                            <div style=\"overflow-x:auto;\">
                            <div class=\"table center\">
                                <div class=\"tr white_a \">
                                    <span class=\"th admin_table_border\">Data</span>
                                    <span class=\"th admin_table_border\">Login</span>
                                    <span class=\"th admin_table_border\">Szczegóły</span>
                                    <span class=\"th admin_table_border\">Usuwanie</span>
                                </div>";
                                if($orders_data!="Brak zamówień") echo $orders_data;
                            echo "</div></div>";
                        }
                    }
                ?>
                    <br>
                    <div class="pagination_div">
                        <?php if(isset($pagination_bar)) echo $pagination_bar; ?>
                    </div>
            </div> 
    
</div>
<script>
    
function check_if_sure(button)
{
    try
    {
        if(button)
        {
            if(button.textContent=="Usuń")
            {
                var x=confirm("Czy napewno chcesz usunąć tego użytkownika?");
                return x;
            }
            else
                return true;
        }
    }catch(err){}
       
}

</script>
</body>
</html>