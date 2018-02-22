<?php
require_once "connect.php";
require_once "test.php";
require_once "stringGenerator.php";

if(isset($_POST['mail']))
{
    $link=mysqli_connect($host, $db_user, $db_password, $db_name) or die (mysqli_connect_error());

    if(mysqli_connect_errno())
    {
        echo "Problem z połączeniem z bazą danych";
        exit();
    }
    else
    {
        mysqli_query($link,"SET CHARSET utf8");
        mysqli_query($link,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");
        $mail=test_input($_POST['mail'],$link);
        $q= mysqli_fetch_assoc( mysqli_query($link, "select count(*) cnt,idUzytkownika from Uzytkownicy WHERE mail='$mail';"));
        if($q['cnt']<=0)
        {
            echo '<center><h2 style="color:dimgray;padding-top:10px;"">Niepoprawny adres email</h2></center>';
        }
        else
        {
            
            $salt = uniqid(mt_rand(), true);
            $salt = substr($salt,0,10);
            $password = generateRandomString(10);
            $password_encrypted=sha1(sha1($password).$salt);
            
            mysqli_query($link,"UPDATE Uzytkownicy SET haslo='$password_encrypted',sol='$salt' WHERE idUzytkownika='{$q['idUzytkownika']}';");
            
            echo '<center><h2 style="color:dimgray;padding-top:10px;">Haslo:'.$password.'<br>Wiadomość z nowym hasłem została wysłana na e-mail: '.$mail.'</h2></center>';
        }
        mysqli_close($link);
    }
}

?>


<!DOCTTYPE html>
<head>
    <title>Przypomnienie hasła</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="shortcut icon" href="images/pill.png" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
<div class="container">
    <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript> 
	<form action="" method="post">
		<div class="login_panel">
            <h2 class="gray_header">Wpisz adres e-mail, na który zostanie wysłane nowe hasło</h2>
            <input class ="center" type="email" name="mail" placeholder="Wpisz adres e-mail" required="required" pattern=".{5,50}" title="5-50 znaków" onblur="email_check_ajax(this.value);"/>
            <div id="email_reminder_answer"></div>
            <div class="password_reminder_buttons">
                <button class="reminder_button" type="submit" >Wyślij Przypomnienie</button>
                <a href="login.php">
                    <button class="reminder_button" type="button" >Anuluj</button
                </a>
            </div>
		</div>
	</form>
<script>
   
function email_check_ajax(mail_addr)
{
    var answerBox=document.getElementById("email_reminder_answer");
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
    xhttp.open("POST","email_check_for_pass_reminder.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("mail="+mail_addr);
}      

            
</script>
            
</div>
</body>
</html>