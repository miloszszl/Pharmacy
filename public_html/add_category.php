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
else
{
    $answer="";
    if(isset($_POST['category']) && !empty($_POST['category']))
    {
        if(empty($_POST['category']) or strlen(trim($_POST['category']))==0 or strlen(trim($_POST['category']))>50)
            $answer="Niepoprawna nazwa";
        else
        {
            try
            {  
                mysqli_query($link,"SET CHARSET utf8");
                mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
                
                mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;");
                mysqli_query($link,"START TRANSACTION;");

                $category_name=test_input($_POST['category'],$link);
                
                $q=mysqli_query($link,"SELECT count(*) cnt FROM Kategorie WHERE LOWER(nazwa)=LOWER('$category_name');");
                
                if(!$q)
                    throw new Exception();
                
                $categories_q=mysqli_fetch_assoc($q);
                
                if($categories_q['cnt']<=0)
                {
                    $q1=mysqli_query($link,"INSERT INTO Kategorie (nazwa) VALUES ('$category_name')");   
                    
                    if(!$q1)
                        throw new Exception();
                    else
                        $answer='<h1 style="color:#8af294" >Pomyślnie dodano kategorię</h1>';
                }
                else
                {
                    $answer="Taka kategoria już istnieje";
                }
                
                if(!mysqli_error($link))
                    mysqli_query($link,"COMMIT");
                else
                    mysqli_query($link,"ROLLBACK");
            }
            catch(Exception $e)
            {
                $answer="Marka nie została dodana";
                 mysqli_query($link,"ROLLBACK");
            }
        }
    }

    $select_categories_q=mysqli_query($link,"SELECT * FROM Kategorie;");
    if($select_categories_q)
    {
        $categories="";
        while($row=mysqli_fetch_assoc($select_categories_q))
        {
            $categories=$categories.$row['nazwa']."<br>"; 
        }
    }
    
}
mysqli_close($link);
?>


<!DOCTYPE html>
<head lang="pl">
    <title>Dodaj kategorię</title>
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
            <center><button onClick="javascript:window:location.href='index.php';" class="btn btn-default btn-success btn-lg" type="button">Sklep</button><!--id="admin_shop_button"--></center>
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
    <div id="admin_answer" style="color:#fc7676;text-align:center;"><?php if(isset($answer)) echo "<h2>".$answer."</h2>";?></div>
    <div id="admin_panel">
        <div class="add_panel">
            <h2 style="color:white">Dodawanie kategorii</h2>
            <br>
            <div id="category_answer" style="color:white;" ></div>
            <form action="" method="post" onsubmit="return check_onsubmit(event)">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <input id="category_input"  class="form-control in" type="text" placeholder="Kategoria" name="category" required pattern=".{1,50}" title="1-50 znaków" onblur="check_category_redundantion();">
                    </div>
                </div>
                <div class="row"><button class="btn btn-success btn-lg" type="submit">Dodaj</button></div>
            </form>
            <br>
            <button class="btn btn-success btn-lg" id="show_categories">Kategorie</button>
            <div id="actual_categories_box">
                <h3>Aktualne kategorie:</h3>
                <?php
                    if(isset($categories)) echo $categories;
                ?>
            </div>
            
        </div>     
    </div>
    </div>
    
</div>
<script>

$("#show_categories").click(function(){
    try
    {
        $('#actual_categories_box').toggle();
        var x=$("#show_categories").text();
        if(x=="Schowaj")
            $("#show_categories").text("Pokaż");
        else
            $("#show_categories").text("Schowaj");
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana");
    }
});
    
    
function check_category_redundantion()
{
    try
    {
        if(!document.getElementById('category_input') || !document.getElementById('category_answer'))
            throw "no elements";
    
        var value=document.getElementById('category_input').value;
        var answerBox=document.getElementById('category_answer');
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
            }
            else if(this.responseText=="not ok")
            {
                answerBox.innerHTML="Niepoprawna nazwa";
            }
            else
            {
                answerBox.innerHTML = this.responseText;
            }

        }
        };
        xhttp.open("POST", "categories_redundantion.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("category_name="+value);
    }
    catch(err)
    {
        alert("Błąd, operacja została przerwana"); 
    }
};

function check_onsubmit(evt)
{
    try
    {
        //evt.preventDefault();
        if(document.cookie.indexOf('c_redundantion') >= 0)
        {
            document.cookie = "c_redundantion=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
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