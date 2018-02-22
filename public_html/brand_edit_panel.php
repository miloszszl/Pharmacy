<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

$answer="";   
if(!empty($_GET['brand_id']))
{
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
        $brand_id=test_input($_GET['brand_id'],$link);
        try
        {   
            $brand_q=mysqli_query($link,"SELECT * FROM Marki WHERE idMarki=$brand_id;");

            if(!$brand_q)
                throw new Exception();

            if($brand_q and mysqli_num_rows($brand_q)>0)
                $brand_data=mysqli_fetch_assoc($brand_q);
            else
                $answer='Taka marka nie istnieje<br>';
        }
        catch(Exception $e)
        {
            $answer.="Taka marka nie istnieje, operacja została przerwana<br>";
        }
    }
    mysqli_close($link);
}
else
{
    header("Location:index.php");
}

if(isset($_GET['answer']))
{
    $answer.=htmlspecialchars($_GET['answer'], ENT_QUOTES, 'UTF-8');
    $answer=str_replace("\n","<br>",$answer,$i);

    if($answer=="Pomyślnie edytowano markę")
    {
        $answer="<span style=\"color:#8af294\">".$answer."</span>";
    }
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
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><h1><?php if(isset($answer)) echo $answer;?></h1></div>
            <div id="admin_panel" style="color:white;">
                <h2 style="text-align:center;">Edycja marki</h2><br>

                    <form method="POST" action="brand_edit_execution.php">
                        <div id="category_edit_box" >
                            Nazwa marki:<br>
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <input type="text" class="form-control in"  name="new_brand_name" required pattern=".{1,50}" title="1-50 znaków" value="<?php if(isset($brand_data)) echo $brand_data['nazwa']; ?>">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-lg" value="<?php if(isset($brand_data)) echo $brand_data['idMarki'];?>" name="submit_brand_edit">Zatwierdź</button>
                            
                            <button onClick="javascript:window:location.href='edit_brand.php';" class="btn btn-success btn-lg" type="button" >Powrót</button>
                        </div>
                    </form>
            </div>
    </div> 
</div>      

<script>
</script>
</body>
</html>