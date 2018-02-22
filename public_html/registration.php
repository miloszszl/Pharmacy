<?php
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

require_once "connect.php";
require_once "test.php";

$link=@mysqli_connect($host, $db_user, $db_password, $db_name) or die ('<h2 style="color:dimgray;text-align:center;">Problem z połączeniem z bazą danych</h2>');

mysqli_query($link,"SET CHARSET utf8;");
mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`;");

$name=$surname=$login=$password1=$password2=$email=$phone=$city=$street=$house_number="";
$flag=true;

if(isset($_POST['register']))
{
    $answer="";
        
    if(empty($_POST['login']) or empty($_POST['first_name']) or empty($_POST['last_name']) or empty($_POST['password']) or empty($_POST['password2']) or empty($_POST['e_mail']) or empty($_POST['l_telephone']) or empty($_POST['l_city']) or  empty($_POST['l_street']) or empty($_POST['l_house_number']))
    {
        $answer='<center><h2 style="color:dimgray">Proszę wypełnić wszystkie pola</h2></center>';
    }
    else
    {
        if(!isset($_POST['regulations']))
        {
            $answer= '<center><h2 style="color:dimgray;"">Zaakceptuj regulamin</h2></center>';
            $flag=false;
        }

        $name=test_input($_POST['first_name'],$link);
        $surname=test_input($_POST['last_name'],$link);
        $login=test_input($_POST['login'],$link);
        $password1=test_input($_POST['password'],$link);
        $password2=test_input($_POST['password2'],$link);
        $email=test_input($_POST['e_mail'],$link);
        $phone=test_input($_POST['l_telephone'],$link);
        $city=test_input($_POST['l_city'],$link);
        $street=test_input($_POST['l_street'],$link);
        $house_number=test_input($_POST['l_house_number'],$link);


        if(strlen($name)>30 or strlen($name)<3)
        {
            $answer.= '<center><h2 style="color:dimgray;">Niepoprawna długość imienia</h2></center>';
            $flag=false;
        }

        if(strlen($surname)>30 or strlen($surname)<3)
        {
            $answer.='<center><h2 style="color:dimgray;">Niepoprawna długość nazwiska</h2></center>';
            $flag=false;
        } 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $answer.='<center><h2 style="color:dimgray;">Niepoprawny format adresu email</h2></center>';
            $flag=false;
        }

        /*$mail_q= mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy WHERE mail='$email';"));
        if($mail_q['cnt']>0)
        {
            $answer.='<center><h2 style="color:dimgray;">Taki e-mail już istnieje</h2></center>';
            $flag=false;
        }

        $login_q = mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) cnt FROM Uzytkownicy WHERE login='$login';"));
        if($login_q['cnt']>0)
        {
            $answer.='<center><h2 style="color:dimgray;">Taki login już istnieje</h2></center>';
            $flag=false;
        }*/

        if(strlen($login)>20 or strlen($login)<=0)
        {
            $answer.='<center><h2 style="color:dimgray;">Niepoprawna długość loginu</h2></center>';
            $flag=false;
        }

        if(preg_match('/\s/',$login))
        {
            $answer.='<center><h2 style="color:dimgray;">Login nie może zawierać spacji</h2></center>';
            $flag=false;
        }

        if($password1!=$password2)
        {      
            $answer.='<center><h2 style="color:dimgray;"">Hasła są różne</h2></center>';
            $flag=false;
        }

        if(!(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/", $phone) or preg_match("/^[0-9]{9}$/", $phone) or preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/", $phone))) 
        {
            $answer.='<center><h2 style="color:dimgray;"">Numer telefonu jest niepoprawny</h2></center>';
            $flag=false;
        }

        $street=trim($street);
        if(strlen($street)>30 or strlen($street)<3)
        {
            $answer.='<center><h2 style="color:dimgray;"">Nieoporawna długość nazwy ulicy</h2></center>';
            $flag=false;
        }

        $house_number=trim($house_number);
        if(strlen($house_number)>10 or strlen($house_number)<1)
        {
            $answer.='<center><h2 style="color:dimgray;"">Niepoprawna długość numeru domu</h2></center>';
            $flag=false;
        }

        if($flag)
        {
            try
            {

                mysqli_query($link,"SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
                mysqli_query($link,"START TRANSACTION;");

                $city_q = mysqli_query($link,"SELECT idMiasta FROM Miasta WHERE nazwa='$city'");
                if(!$city_q or mysqli_num_rows($city_q)==0)
                    throw new Exception('<center><h2 style="color:dimgray">Nie ma takiego miasta.<br>Rejestracja nieudana</h2></center>');

                $salt = uniqid(mt_rand(), true);
                $salt = substr($salt,0,10);
                $password1=sha1(sha1($password1).$salt);

                $city_q_assoc=mysqli_fetch_assoc($city_q);

                $acc_type_q=mysqli_query($link,"SELECT idTypuKonta FROM TypyKont WHERE typKonta='użytkownik';");

                if(!$acc_type_q or mysqli_num_rows($acc_type_q)==0)
                    throw new Exception('<center><h2 style="color:dimgray">Problem z bazą danych<br>Rejestracja nieudana</h2></center>');

                $acc_type_q_assoc=mysqli_fetch_assoc($acc_type_q);
                $id_acc_type=$acc_type_q_assoc['idTypuKonta'];
                $id_city=$city_q_assoc["idMiasta"];

                $insert_q=mysqli_query($link,"insert into Uzytkownicy (imie,nazwisko,login,haslo,mail,telefon,idMiasta,nazwaUlicy,numerDomu,idTypuKonta,sol) values ('$name','$surname','$login','$password1','$email','$phone',$id_city,'$street','$house_number',$id_acc_type,'$salt');");

                if(!$insert_q)
                {
                    throw new Exception('<center><h2 style="color:dimgray">Login lub email są już zajęte</h2></center>');
                }
                    //setcookie('emailAddress',$email);
                    mysqli_query($link,"COMMIT");
                    setcookie('registeredFlag',true);
                    header('Location: registered.php');
            }
            catch(Exception $e)
            {
                $answer.=$e->getMessage();
                mysqli_query($link,"ROLLBACK");
            }

        }
    }
}


$select_q=mysqli_query($link,"SELECT * FROM Miasta;");
if($select_q)
{
    $options="";
    while($row=mysqli_fetch_assoc($select_q))
    {
        $options=$options."<option>".$row['nazwa']."</option>"; 
    }  
}
else
    $answer.='<center><h2 style="color:dimgray">Błąd bazy danych</h2></center>';

mysqli_close($link);


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link rel="shortcut icon" href="images/pill.png" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
    <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript>
<center>

<div class="container-fluid"> 
    <div class="row" >
        <?php if(!empty($answer)) echo $answer; ?>
    </div>
    <div class="row registration">
        <form class="form-group " name="reg" method="post" action="registration.php">
            <div id="login_answer"></div>
            <input class ="form-control in" type="text" name="login" placeholder="Wpisz login" required="required" pattern=".{5,20}" title="5-20 znaków" onblur="check_availability('login',this.value,'login_check.php','login_answer','');"/>    
            <input class ="form-control in" id="pass1" type="password" name="password" placeholder="Wpisz hasło" required="required" pattern=".{5,20}" title="5-20 znaków"/>
            <input class ="form-control in" id="pass2" type="password" name="password2" placeholder="Powtórz hasło" required="required" pattern=".{5,20}" title="5-20 znaków" onblur="checkPass();"/>
            <input class ="form-control in" type="text" name="first_name" placeholder="Wpisz imię" required="required" pattern=".{3,30}" title="3-30 znaków"/>
            <input class ="form-control in" type="text" name="last_name" placeholder="Wpisz nazwisko" required="required" pattern=".{3,30}" title="3-30 znaków"/>
            <div id="email_answer"></div>
            <input class ="form-control in" type="email" name="e_mail" placeholder="Wpisz adres e-mail" required="required" pattern=".{5,50}" title="5-50 znaków" />
            <input class ="form-control in" type="text" name="l_telephone" placeholder="Podaj numer telefonu" required="required" pattern="(^\d{3}-\d{3}-\d{3}$|^\d{9}$|\d{2}-\d{3}-\d{2}-\d{2}$)" title="9 cyfr przedzielonych znakiem '-' lub pisanych łącznie"/>
            <!--<input class ="center" type="text" name="l_city" placeholder="Podaj nazwę miasta" required="required" pattern=".{3,30}" title="3-30 znaków"/>-->

            <select class="form-control in" name="l_city">
                <option>Wybierz Miasto</option>
                <?php
                    if(isset($options)) echo $options;  
                ?>
            </select>
            <input class ="form-control in" type="text" name="l_street" placeholder="Wpisz nazwę ulicy" required="required" pattern=".{3,30}" title="3-30 znaków"/>
            <input class ="form-control in" type="text" name="l_house_number" placeholder="Wpisz numer domu" required="required" pattern=".{1,10}" title="1-10 znaków"/>
            <!--<div class="g-recaptcha" data-sitekey="6LcdchgTAAAAACL1Z9w9R1D7usdeJWyy88V3JQpt"></div>-->
            <div class="rules">
                <input type="checkbox" name="regulations" checked="checked" style="display:inline-block;"> Akceptuję <a href="regulations.php" class="reg">regulamin</a>
            </div>
            <br>
            <div class="buttons_registration">
            <div class="row">
                <button type="submit" name="register" class="btn btn-success btn-lg" style="margin-top:5px">Zarejestruj</button>
                <button type="button" style="margin-top:5px" onClick="javascript:window:location.href='index.php';" class="btn btn-success btn-lg" >Anuluj</button>
            </div>
            </div>

        </form>
    </div>
</div>
</center>
	<script>
        
        
function check_availability(varName,value,fileName,containerName,emptyVal)
{
    try
    {
        var answerBox=document.getElementById(containerName);
        if(value.trim()=='')
        {

            answerBox.innerHTML=emptyVal;
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
    

        
    
function checkPass()
{
    try
    {
      var pass1=document.getElementById("pass1");  
      var pass2=document.getElementById("pass2"); 
        if(pass1.value!=pass2.value)
        {
            alert("Hasła są różne");
            pass1.value="";
            pass2.value="";
            pass1.focus();
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
