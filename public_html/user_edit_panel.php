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
        $q=mysqli_query($link,"DELETE FROM Uzytkownicy WHERE idUzytkownika='$val';");

        if(mysqli_affected_rows($link)>0)
        {
            $answer="Usunięto użytkownika o id=$val";
        }
        else
        {
            $answer="Operacja usuwania nie została wykonana";
        }

        header("Location: edit_user.php?answer=".$answer);
    }
    elseif(isset($_GET['user_id']))
    {
        $user_id=test_input($_GET['user_id'],$link);
        $user_q=mysqli_query($link,"SELECT * FROM Uzytkownicy WHERE idUzytkownika=$user_id;");
        if(mysqli_num_rows($user_q)>0)
        {
            $user_data=mysqli_fetch_assoc($user_q);
            foreach ($user_data as $k=>$v) {$user_data[$k] = test_input($v,$link);}

            $city_id=$user_data['idMiasta'];
            $city_q=mysqli_query($link,"SELECT * FROM Miasta;");
            $cities="";
            while($row=mysqli_fetch_assoc($city_q))
            {
                if($row['idMiasta']==$city_id)
                    $cities.="<option selected>".$row['nazwa']."</option>"; 
                else
                    $cities.="<option>".$row['nazwa']."</option>"; 
            } 


            $account_type_id=$user_data['idTypuKonta'];
            $account_types_q=mysqli_query($link,"SELECT * FROM TypyKont;");
            $account_types="";
            while($row=mysqli_fetch_assoc($account_types_q))
            {
                if($row['idTypuKonta']==$account_type_id)
                    $account_types.="<option selected>".$row['typKonta']."</option>"; 
                else
                    $account_types.="<option>".$row['typKonta']."</option>"; 
            }

        }
        else
        {
            $answer="Nie ma takiego użytkownika<br>";
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

        if($answer=="Edycja użytkownika przebiegła pomyślnie")
        {
            $answer="<span style=\"color:#8af294\">".$answer."</span>";
        }
    }
}
mysqli_close($link);













/*



$loged_in=false;
$admin=false;

$category_data="";
$answer="";
$users_data="";
if(isset($_COOKIE['id']) && isset($_COOKIE['token']))
{

    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

    mysqli_query($link,"SET CHARSET utf8");
    mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
            
    foreach ($_COOKIE as $k=>$v) {$_COOKIE[$k] = test_input($v,$link);}
    foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = test_input($v,$link);}
    
    $session_q = mysqli_fetch_assoc(mysqli_query($link, "SELECT token FROM Sesja WHERE id = '{$_COOKIE['id']}' AND web = '{$_SERVER['HTTP_USER_AGENT']}' AND ip = '{$_SERVER['REMOTE_ADDR']}';"));
    
    if($session_q['token']==$_COOKIE['token'])
    {
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        $token=generateRandomString();
        setcookie('token',$token);
        mysqli_query($link,"UPDATE Sesja set token='$token' WHERE id='$_COOKIE[id]' AND web = '$_SERVER[HTTP_USER_AGENT]' AND ip = '$_SERVER[REMOTE_ADDR]';");
        $loged_in=true;
        
        $account_types_q= mysqli_fetch_assoc( mysqli_query($link, "SELECT typKonta FROM TypyKont WHERE idTypuKonta=(SELECT idTypuKonta FROM Uzytkownicy u INNER JOIN Sesja s ON s.idUzytkownika=u.idUzytkownika WHERE s.id='{$_COOKIE['id']}');"));
        
        if($account_types_q['typKonta']=='administrator')
        {
            $admin=true;
        }
    }
    else
    {
        $q = mysqli_query($link, "DELETE FROM Sesja WHERE id = '$_COOKIE[id]';");	
        setcookie("id",0,time()-1);
        unset($_COOKIE['id']);
        setcookie("token",0,time()-1);
        unset($_COOKIE['token']);
        header("location:index.php");
    }
    
    if(!($admin && $loged_in))
    {
        header('Location:index.php');
    }
    else
    {
        if(isset($_GET['delete_button']))
        {
            $val=test_input($_GET['delete_button'],$link);//<h1 style=\"color:#8af294\" >
            $q=mysqli_query($link,"DELETE FROM Uzytkownicy WHERE idUzytkownika='$val';");
            
            if(mysqli_affected_rows($link)>0)
            {
                $answer="Usunięto użytkownika o id=$val";
            }
            else
            {
                $answer="Operacja usuwania nie została wykonana";
            }
            
            header("Location: edit_user.php?answer=".$answer);
        }
        elseif(isset($_GET['user_id']))
        {
            $user_id=test_input($_GET['user_id'],$link);
            $user_q=mysqli_query($link,"SELECT * FROM Uzytkownicy WHERE idUzytkownika=$user_id;");
            if(mysqli_num_rows($user_q)>0)
            {
                $user_data=mysqli_fetch_assoc($user_q);
                foreach ($user_data as $k=>$v) {$user_data[$k] = test_input($v,$link);}
                
                $city_id=$user_data['idMiasta'];
                $city_q=mysqli_query($link,"SELECT * FROM Miasta;");
                $cities="";
                while($row=mysqli_fetch_assoc($city_q))
                {
                    if($row['idMiasta']==$city_id)
                        $cities.="<option selected>".$row['nazwa']."</option>"; 
                    else
                        $cities.="<option>".$row['nazwa']."</option>"; 
                } 
                
                
                $account_type_id=$user_data['idTypuKonta'];
                $account_types_q=mysqli_query($link,"SELECT * FROM TypyKont;");
                $account_types="";
                while($row=mysqli_fetch_assoc($account_types_q))
                {
                    if($row['idTypuKonta']==$account_type_id)
                        $account_types.="<option selected>".$row['typKonta']."</option>"; 
                    else
                        $account_types.="<option>".$row['typKonta']."</option>"; 
                }
                
            }
            else
            {
                $answer="Nie ma takiego użytkownika<br>";
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

            if($answer=="Edycja użytkownika przebiegła pomyślnie")
            {
                $answer="<span style=\"color:#8af294\">".$answer."</span>";
            }
        }
    }
    mysqli_close($link);
}
else
{
    header("Location: index.php");
    exit();
}*/
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
            <div id="admin_panel" style="color:white;">
                <h2 style="text-align:center;">Edycja użytkownika</h2>
                <br>
                
                <div class="additional_user_options">
                    <form method="POST" action="user_edit_additional_options.php" class="center_text" onsubmit="return check_if_sure(this.submited);">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="submit" class="btn btn-success btn-lg" style="width:250px;" id="delete_user" value ="<?php if(isset($user_data['idUzytkownika'])) echo "{$user_data['idUzytkownika']}";?>" name="submit_delete_user" onclick="this.form.submited=this;">Usuń użytkownika</button>
                            </div>
                            <div class="col-sm-4 ">
                                <button type="submit" class="btn btn-success btn-lg" style="width:250px;" id="submit_new_user_pass" value ="<?php if(isset($user_data['idUzytkownika'])) echo "{$user_data['idUzytkownika']}";?>" name="submit_new_user_pass" onclick="this.form.submited=this;">Nadaj nowe hasło</button>  
                            </div>
                        </div>
                        
                    </form>
                </div>
                <br>
                <br>
                
                <form method="POST" action="user_edit_execution.php" class="center_text">
                    <h2>Formularz edycji danych użytkownika</h2>
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Login:</label>
                        </div>
                        <div class="col-sm-3 "> 
                            <input type="text" class="form-control in" placeholder="Wpisz login" required="required" pattern=".{5,20}" name="user_login_input" value ="<?php if(isset($user_data['login'])) echo stripslashes($user_data['login']);?>" title="5-20 znaków" onblur="check_availability('login',this.value,'login_check.php','login_answer','Nie podano loginu');"/>
                        </div>
                    </div>
                    <div class="row">
                        <div id="login_answer"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Imię:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input type="text" class="form-control in" value="<?php if(isset($user_data['imie'])) echo stripslashes($user_data['imie']);?>" name="user_name_input" placeholder="Wpisz imię" required="required" pattern=".{3,30}" title="3-30 znaków">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Nazwisko:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input type="text" class="form-control in" value="<?php if(isset($user_data['nazwisko'])) echo stripslashes($user_data['nazwisko']);?>" name="user_surname_input" placeholder="Wpisz nazwisko" required="required" pattern=".{3,30}" title="3-30 znaków">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">E-mail:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input  type="text" class="form-control in" value="<?php if(isset($user_data['mail'])) echo stripslashes($user_data['mail']);?>" name="user_email_input" placeholder="Wpisz adres e-mail" required="required" pattern=".{5,50}" title="5-50 znaków" onblur="check_availability('email',this.value,'email_check.php','email_answer','Nie podano adresu email');">
                        </div>
                    </div>
                    <div class="row">
                        <div id="email_answer"></div>
                    </div>
                    
    
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Telefon:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input  type="text" class="form-control in" value="<?php if(isset($user_data['telefon'])) echo stripslashes($user_data['telefon']);?>" name="user_phone_input" name="phone" placeholder="Podaj numer telefonu" required="required" pattern="(^\d{3}-\d{3}-\d{3}$|^\d{9}$|\d{2}-\d{3}-\d{2}-\d{2}$)" title="9 cyfr przedzielonych znakiem '-' lub pisanych łącznie">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Miasto:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <select class="form-control in" name="user_city_input">
                                <?php
                                    if(isset($cities)) echo stripslashes($cities);  
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Nazwa ulicy:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input type="text" class="form-control in" value="<?php if(isset($user_data['login'])) echo stripslashes($user_data['nazwaUlicy']);?>" name="user_street_input" placeholder="Wpisz nazwę ulicy" required="required" pattern=".{3,30}" title="3-30 znaków">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Numer domu:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <input type="text" class="form-control in" value="<?php if(isset($user_data['login'])) echo stripslashes($user_data['numerDomu']);?>" name="user_house_num_input" placeholder="Wpisz numer domu" required="required" pattern=".{1,10}" title="1-10 znaków">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-4">
                            <label class="user_label" style="margin-top:4px;">Typ konta:</label>
                        </div>
                        <div class="col-sm-3 ">
                            <select class="form-control in" name="user_account_type_input">
                                <?php
                                    if(isset($account_types)) echo stripslashes($account_types);  
                                ?>
                            </select>
                        </div>
                    </div>
                <div class="row" style="padding:20px;"> 
                    <button type="submit" class="btn btn-success btn-lg" id="submit_user_edit" value ="<?php if(isset($user_data['idUzytkownika'])) echo "{$user_data['idUzytkownika']}";?>" name="submit_user_edit">Zatwierdź</button>
                    <button onclick="javascript:window.location.href='edit_user.php';" class="btn btn-success btn-lg" type="button">Powrót</button> 
                </div>
            </form>                            
        </div>
    </div> 
</div>       
<script>
    
    function check_if_sure(button)
    {
        try
        {
            if(button.textContent=="Usuń użytkownika")
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
    
    
    
    function check_availability(varName,value,fileName,containerName,emptyVal)
        {

            try
            {
                
                var answerBox=document.getElementById(containerName);
                
                if(!varName || !value || !fileName || !containerName|| !emptyVal)
                    throw "wrong parameters"
                
                if(value.trim()=='')
                {

                    loginAnswer.innerHTML=emptyVal;
                }
                else
                {
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
                            answerBox.innerHTML ="";
                        else
                            answerBox.innerHTML = this.responseText;
                    }
                    };
                    xhttp.open("POST", fileName, true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(varName+"="+value);
                }
            }
            catch(err)
            {
                alert("Błąd, operacja została przerwana");
            }
        }
</script>
</body>
</html>