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
    if(isset($_POST['add']))
    {
        foreach ($_POST as $k=>$v) {$_POST[$k] = test_input($v,$link);}
        $flag=true;

        if(isset($_POST['delivery_price']) && !empty($_POST['delivery_price']))
        {
            if(!is_numeric($_POST['delivery_price']) or $_POST['delivery_price']<0 or $_POST['delivery_price']>=1000)
            {
                $flag=false;
                $answer.="Niepoprawna cena<br>";
            }
        }
        else
        {
            $flag=false;
            $answer.="Niepoprawna cena<br>";
        }

        if(isset($_POST['delivery_name']) && !empty($_POST['delivery_name']))
        {
            if(trim($_POST['delivery_name'])=="" or strlen(trim($_POST['delivery_name']))>50)
            {
                $flag=false;
                $answer.="Niepoprawna nazwa<br>";
            }
        }
        else
        {
            $flag=false;
            $answer.="Niepoprawna nazwa<br>";
        }

        if($flag==true)
        {
            $q=true;
            
            try
            {
                if(!mysqli_query($link,"CALL insert_delivery(UPPER('$_POST[delivery_name]'),$_POST[delivery_price]);"))
                    throw new Exception(mysqli_error($link));
                $answer.='<span style="color:#8af294" >Pomyślnie dodano dostawcę</span>';
                mysqli_query($link,"COMMIT");
            }
            catch(Exception $e)
            {
                $answer.=$e->getMessage()."<br>";
                mysqli_query($link,"ROLLBACK");
            }
           
        }
        else
        {
            $answer.="Dodawanie dostawcy niepomyślne<br>";
        }
    }


    $select_delivery_q=mysqli_query($link,"SELECT * FROM Dostawcy;");
    if($select_delivery_q)
    {
        $deliveries="";
        while($row=mysqli_fetch_assoc($select_delivery_q))
        {
            $deliveries.=$row['nazwa']." : ".$row['cena']." zł<br>"; 
        }
    }
}

mysqli_close($link);
?>


<!DOCTYPE html>
<head lang="pl">
    <title>Dodaj dostawcę</title>
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
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><?php if(isset($answer)) echo "<h2>".$answer."</h2>"; ?></div>
    <div id="admin_panel">
        <div class="add_panel">
            <h2 style="color:white">Dodawanie dostawcy</h2>
            <br>
            <div id="delivery_answer" style="color:white;"></div>
            <form action="" method="post" onsubmit="return check_onsubmit(event)">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <input id="delivery_input" class="form-control in" type="text" placeholder="Dostawca" name="delivery_name" required pattern=".{1,50}" title="1-50 znaków" onblur="check_delivery_redundantion();">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <input id="delivery_input" class="form-control in" type="number" placeholder="Cena" name="delivery_price" step="0.01" max="999.99" min="0.00" title="cena">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg" name="add">Dodaj</button><br><br>
            </form>
            <button id="show_deliveries" class="btn btn-success btn-lg">Dostawcy</button>
            <div id="actual_deliveries_box">
                <h3>Aktualni dostawcy:</h3>
                <?php
                    if(isset($deliveries)) echo $deliveries;
                ?>
            </div>
            
        </div>     
    </div> 
    </div>
    
</div>      
<script>

$("#show_deliveries").click(function(){
    try
    {
        $('#actual_deliveries_box').toggle();
        var x=$("#show_deliveries").text();
        if(x=="Schowaj")
            $("#show_deliveries").text("Pokaż");
        else
            $("#show_deliveries").text("Schowaj");
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana");
    }
});

    
function check_delivery_redundantion()
{
    try
    {
        var e1=document.getElementById('delivery_input');
        var answerBox=document.getElementById('delivery_answer');
        if(!e1 || !answerBox)
            throw "no elements"
            
        var value=document.getElementById('delivery_input').value;
        
        var xhttp;
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
            if(this.responseText=="ok")
            {
                answerBox.innerHTML ="";
                return true;
            }
            else
            {
                answerBox.innerHTML = this.responseText;
                return false;
            }

        }
        };
        xhttp.open("POST", "delivery_redundantion.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("delivery_name="+value);
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana");
    }
};

function check_onsubmit(evt)
{
    //evt.preventDefault();
    try
    {
        if(document.cookie.indexOf('d_redundantion') >= 0)
        {
            return false;
        }      
        else
            return true; 
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana"); 
    }
        
};
    
</script>
</body>
</html>