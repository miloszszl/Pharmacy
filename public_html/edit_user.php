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
$users_data="";
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
    if(isset($_POST['user_login_input']))
    {
        $login=test_input($_POST['user_login_input'],$link);
        $users_q=mysqli_query($link,"SELECT * from Uzytkownicy WHERE LOWER(login)=LOWER('$login');");
        if(mysqli_num_rows($users_q)>0)
        {
            $users_q_result=mysqli_fetch_assoc($users_q);

            $users_data.="<form class=\"tr white_a\" method=\"GET\" onsubmit=\"return check_if_sure(this.submited);\" action=\"user_edit_panel.php\"><span class=\"td\">{$users_q_result['idUzytkownika']}</span><span class=\"td\">{$users_q_result['login']}</span><span class=\"td\"><button type=\"submit\" onclick=\"this.form.submited=this;\" name=\"user_id\" value=\"{$users_q_result['idUzytkownika']}\">Edytuj</button></span><span class=\"td\"><button type=\"submit\" onclick=\"this.form.submited=this;\" name=\"delete_button\" value=\"{$users_q_result['idUzytkownika']}\">Usuń</button></span></form>";
        }
        else
        {
            $answer.="Nie znaleziono uzytkownika";
        }

    }
    else
    {
        if(isset($_GET['answer']))
        {
            $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
            $answer=str_replace("\n","<br>",$answer,$i);

            if(startsWith($answer, "Usunięto użytkownika o id="))
            {
                $answer="<span style=\"color:#8af294\">".$answer."</span>";
            }
        }

        $users_num_q=mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy;"));

        if($users_num_q['cnt']<=0)
        {
            $answer.="Brak użytkowników w bazie";
        }
        else
        {
            $all_users=$users_num_q['cnt'];
            $on_page = 10; //ilość leków na stronie
            $nav_limit= 5; //ilość wyświetlanych numerów stron
            $all_pages=ceil($all_users/$on_page);

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

            $user_q=mysqli_query($link,"SELECT * from Uzytkownicy ORDER BY idUzytkownika;");

            if(mysqli_num_rows($user_q)>0)
            {
                while($row=mysqli_fetch_assoc($user_q))
                {
                     $users_data.="<form class=\"tr white_a\" onsubmit=\"return check_if_sure(this.submited);\" method=\"GET\" action=\"user_edit_panel.php\"><span class=\"td\">{$row['idUzytkownika']}</span><span class=\"td\">{$row['login']}</span><span class=\"td\"><button type=\"submit\" onclick=\"this.form.submited=this;\" name=\"user_id\" value=\"{$row['idUzytkownika']}\" class=\"btn btn-success btn-lg\">Edytuj</button></span><span class=\"td\"><button onclick=\"this.form.submited=this;\" type=\"submit\" name=\"delete_button\" value=\"{$row['idUzytkownika']}\" class=\"btn btn-success btn-lg\">Usuń</button></span></form>";
                }
            }
            else
            {
                $answer="Brak użytkowników w bazie";
            }

            $forstart = $page_num - floor($nav_limit/2);

            if($forstart <= 0){ $forstart = 1; }

            $forend = $forstart + $nav_limit;
            if($forend>$all_pages)
                $forend=$all_pages;

            $pagination_bar='<ul class="pagination"><li><a style="color:black" href="edit_user.php?page_num='.$prev.'">&laquo;</a></li>';
            for($forstart;$forstart<=$forend;$forstart++)
            {

                if($forstart==$page_num)
                    $pagination_bar.='<li><a class="active" href="edit_user.php?page_num='.$forstart.'">'.$forstart.'</a></li>';
                else
                    $pagination_bar.='<li><a href="edit_user.php?page_num='.$forstart.'">'.$forstart.'</a></li>';
            }

            $pagination_bar.='<li><a style="color:black" href="edit_user.php?page_num='.$next.'">&raquo;</a></li></ul>';


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
    <div class="row" style="margin-top:30px;">
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(isset($answer)) echo $answer; ?></h1></div>
            <div id="admin_panel">
                <h2 style="text-align:center;color:white;">Edycja użytkowników</h2>
                <form method="POST" action="" class="center_text">
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-3">
                            <input type="text" class="form-control in" placeholder="login użytkownika" name="user_login_input">
                        </div>
                        <div class="col-sm-2" style="margin-top:-6px;"><button type="submit" class="btn btn-success btn-lg" id="user_search_button" >Szukaj</button></div>
                    </div>
                    
                    

                </form>
                <br><br>
                    <div style="overflow-x:auto;">
                        <div class="table center" >
                            <div class="tr white_a ">
                                <span class="th admin_table_border">ID</span>
                                <span class="th admin_table_border">Login</span>
                                <span class="th admin_table_border">Edycja</span>
                                <span class="th admin_table_border">Usuwanie</span>
                            </div>
                            <?php
                                if(isset($users_data)) echo $users_data;
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="pagination_div">
                        <?php if(isset($pagination_bar)) echo $pagination_bar; ?>
                    </div>
            </div>
    </div> 
</div>     
<script>
    
function check_if_sure(button)
{
    try
    {
        if(button.textContent=="Usuń")
        {
            var x=confirm("Czy napewno chcesz usunąć tego użytkownika?");
            return x;
        }
        else
            return true;
    }
    catch(err)
    {}
        
}

</script>
</body>
</html>