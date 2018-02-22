<?php
function test_input($data,$link) 
{
  
  $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  $data = mysqli_real_escape_string($link,$data);
  return $data;
}

/*$data = trim($data);
  $data = stripslashes($data);*/


//broken
function test_cookies()
{
    if(!isset($_COOKIE['test_cookie']))
    {
        setcookie("test_cookie",0,time()-1);
        unset($_COOKIE['test_cookie']);  
    }

    setcookie("test_cookie", "test", time() + 3600);
    
    if(count($_COOKIE) <= 0) 
    {
        echo "<h2>Ciasteczka są wyłączone.Aby Skorzystać z serwisu włącz obsługę ciasteczek.<h2>";
        setcookie("test_cookie",0,time()-1);
        unset($_COOKIE['test_cookie']);
        return false;
    }
}
?>