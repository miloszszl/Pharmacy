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
    $categories="";
    $categories_q=mysqli_query($link,"SELECT * FROM Kategorie;");
    if($categories_q)
    {
        /*$iter=1;*/
        while($row=mysqli_fetch_assoc($categories_q))
        {
            /*$categories.="<tr><td style=\"min-width:50px;\" name=\"id_$iter\">".$row['idKategorii']."</td><td>".$row['nazwa']."</td><td><button type=\"submit\" id=\"ceb_$iter\" name=\"ceb_$iter\" value=\"{$row['idKategorii']}\">Edytuj</button></td><td><button type=\"submit\" id=\"cdb_$iter\" name=\"cdb_$iter\" value=\"{$row['idKategorii']}\">Usuń</button></td></tr>"; 
            $iter++;*/
            
            
            $categories.="<form class=\"tr white_a\" method=\"GET\" action=\"edit_categories_panel.php\"><span class=\"td\">{$row['idKategorii']}</span><span class=\"td\">{$row['nazwa']}</span><span class=\"td\"><button type=\"submit\" name=\"category_id\" value=\"{$row['idKategorii']}\" class=\"btn btn-success btn-lg\">Edytuj</button></span><span class=\"td\"><button onclick=\"delete_category(this,this.parentElement.parentElement)\" class=\"btn btn-success btn-lg\" type=\"button\" name=\"delete_button\" value=\"{$row['idKategorii']}\">Usuń</button></span></form>";
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
    <div id="admin_answer" style="text-align:center;"></div>
    <div id="admin_panel" style="color:white;">
                <h2 style="text-align:center;">Edycja i usuwanie kategorii</h2>
                <div style="overflow-x:auto;">
                    <div class="table center " >
                        <div class="tr white_a ">
                            <span class="th admin_table_border">Id</span>
                            <span class="th admin_table_border">Nazwa</span>
                            <span class="th admin_table_border">Edycja</span>
                            <span class="th admin_table_border">Usuwanie</span>
                        </div>
                        <?php
                            if(isset($categories)) echo $categories;
                        ?>
                    </div>
                </div>
                
                <!--<form method="POST" action="edit_categories_form_handling.php">
                    <div style="overflow-x:auto;">
                    <table align="center" id="categories_table">
                        <tr>
                            <th class="th_left" style="min-width:50px;">Id</th>
                            <th class="th_left">Nazwa</th>
                            <th>Edycja</th>
                            <th>Usuwanie</th>
                        </tr>
                        <?php
                            /*if(!empty($categories)) echo $categories;*/
                        ?>
                    </table>
                    </div>
                </form>-->
                <br>
                <br>
        </div>
    </div> 
</div>
<script>
    function delete_category(td,form)
    {
        var x=confirm("Czy napewno chcesz usunąć tego dostawcę?");

        if(x==false)
            return; 
        
        try
        {
            var xhttp;
            var answerBox=$("#admin_answer");
            
            if(!td || !form || !answerBox)
                throw "Wrong arguments";
            
            var category_id=td.value;
            
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
                    answerBox.html("<h2 style=\"color:#fc7676;\">Nie można usunąć kategorii</h2>");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else if(this.responseText=='Problem z połączeniem z bazą danych')
                {
                    product_purchased('Problem z połączeniem z bazą danych');
                }
                else if(this.responseText=="ok")
                {   
                    form.remove()
                    answerBox.html("<h2 style=\"color:#8af294;\">Pomyślnie usunięto kategorię</h2>");
                }
            }
            };
            xhttp.open("POST", "delete_category.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("category_id="+category_id);  
        }
        catch(err)
        {
                alert("Błąd, operacja została przerwana");
        }
    } 
</script>
    
</body>
</html>