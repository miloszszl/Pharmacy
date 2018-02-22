<?php

header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

if(!(isset($_COOKIE['registeredFlag'])) && ($_COOKIE['registeredFlag']!=true))
{
    header('Location:registration.php');
    exit();
}
else
{
   if(isset($_COOKIE['registeredFlag']) && ($_COOKIE['registeredFlag']==true))
   {
        setcookie('registeredFlag',0,time()-1);
        unset($_COOKIE['registeredFlag']);
   }
}

?>
<!DOCTYPE html>
<head lang="pl">
    <title>Udana rejestracja</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/pill.png" />
    <meta name="keywords" content="Apteka,pharmacy,leki,chemia,bandaż,syrop,tabletki,choroby,przeziebienie">
    <meta name="author" content="Miłosz Szlachetka">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
    <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript> 
    <div class="login_panel">
        <h2 class="gray_header">Zarejestrowano pomyslnie</h2>
            <?php
                /*$address="";
                if(isset($_COOKIE['emailAddress']))
                {
                    $address=$_COOKIE['emailAddress'];
                    setcookie('emailAddress',0,time()-1);
	                unset($_COOKIE['emailAddress']);
                }*/
                /*echo '<span class="registered_content">'."Na adres email: <b>$address</b> została wysłana wiadomość z powtwierdzeniem rejestracji wraz z linkiem aktywacyjnym.".'<span>';*/
            ?>
            <button type="button" onClick="javascript:window:location.href='index.php';" class="button_registered">Powrót do strony głównej</button>
    </div>
<script>
</script>
</body>
</html>