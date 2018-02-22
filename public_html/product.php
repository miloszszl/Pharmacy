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

check_user($link,$loged_in,$admin);

generate_buttons($logout_button,$admin_button,$loged_in,$admin);


{
    if(!empty($_GET['id']))
    {
        $_GET['id']=test_input($_GET['id'],$link);
        
        $product_data="";
        try
        {
            $product_q=mysqli_query($link,"SELECT p.nazwa,p.ilosc,p.cena,p.ocena,p.opis,m.nazwa FROM Produkty p JOIN Marki m ON p.idMarki=m.idMarki WHERE p.idProduktu={$_GET['id']};");

            if(!$product_q)
                throw new Exception();

            if(mysqli_num_rows($product_q)<=0)
            {
                $product_data="Nie ma takiego produktu";
            }
            else
            {   
                if($admin)
                    $product_data.="<div class=\"row\"><form method=\"POST\" action=\"edit_product_panel.php\"><div class=\"col-sm-2 col-sm-offset-4\"><button type=\"submit\" class=\"btn btn-success btn-lg\" name=\"edit_button\" value=\"{$_GET['id']}\">Edytuj</button></div></form><div class=\"col-sm-2\"><button type=\"button\" class=\"btn btn-success btn-lg\" id=\"delete_button\" name=\"delete_button\" value=\"{$_GET['id']}\">Usuń</button></div></div>";

                $product_data_array=mysqli_fetch_array($product_q);
                $product_data.="<div class=\"row\"><h1>".$product_data_array[0]."</h1></div>";
                

                $product_q_pictures=mysqli_query($link,"SELECT z.link FROM Zdjecia z JOIN Produkty p ON p.idProduktu=z.idProduktu WHERE z.idProduktu={$_GET['id']};");

                if(!$product_q_pictures)
                    throw new Exception();

                $product_data.='<div class="row" style="padding:20px;"></div><div class="row"><div class="col-sm-4">';
                
                
                if(mysqli_num_rows($product_q_pictures)<=0)
                {
                    $product_data.='<img src=""alt="Zdjęcie produktu" height="250" width="250">';
                }
                else
                {
                    while($row=mysqli_fetch_assoc($product_q_pictures))
                    $product_data.='<img class="img-thumbnail" src="'.$row['link'].'"alt="Zdjęcie produktu" height="250" width="300">';
                }
                
                
                $product_data.='</div><div class="col-sm-6 col-sm-offset-1">';
                $product_data.='<div id="buy_product_info" style="text-align:center;"><div class="product_info1">Dostępnych sztuk: <b>'.$product_data_array[1].'</b></div>';//style="background-color:green;"
                $product_data.="<div id=\"product_price\">Cena za sztukę: <b>".$product_data_array[2]." zł</b></div>";
                $product_data.='<br><div class="product_info2" >';
                //$product_data.='<form>';   //action="do_koszyka.php" method="post"
                
                $product_data.='<div class="row">
                    <div class="col-sm-5">
                        <input class="form-control in" id="product_input" type="number" placeholder="Ilość" value="1" name="products_quantity" required autofocus maxlength="4">
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-success btn-lg" style="margin-top:-6px;" id="order_button">Do koszyka</button>
                    </div>
                </div>';
                
                $product_data.='<input id="product_id" type="hidden" value="'.$_GET['id'].'">';
                
                
                /*$product_data.='<input class="form-control in" id="product_input" type="text" placeholder="Ilość" value="1" name="products_quantity" required autofocus maxlength="5">';
                $product_data.='<input id="product_id" type="hidden" value="'.$_GET['id'].'">';


                $product_data.='<button class="btn btn-success btn-lg" id="order_button">Do koszyka</button>'; */


                $product_data.="</div>";
                $product_data.='<div id="product_grade">';
                $product_data.="<div>Ocena: <b><span id=\"rate_div\">";
                if($product_data_array[3]=="")
                {
                    $product_data.=" Nikt jeszcze nie ocenił tego produktu";
                }
                else
                {
                    $product_data.=$product_data_array[3];
                }
                $product_data.="</span></b><br><br>";
                
                $product_data.='<div class="row">
                    <label class="control-label col-sm-4">Oceń(1-10):</label>
                    <div class="col-sm-3">
                        <input class="form-control in" style="max-width:100px;margin-left:auto;margin-right:auto;" type="number" id="rate_input" name="rate_input" min="1" max="10" pattern value="10" maxlength="2">
                    </div>
                    <div class="col-sm-3 ">
                        <button class="btn btn-success btn-lg" style="margin-top:-6px;" id="rate_button" name="rate_input" type="button" >Oceń</button>
                    </div>
                </div>';
                
                
                
                /*$product_data.='Twoja ocena(1-10): <input class="form-control in" type="number" id="rate_input" name="rate_input" min="1" max="10" pattern value="10">';
                $product_data.='<button class="btn btn-success btn-lg" id="rate_button" name="rate_input" type="button" >Oceń</button>';*/
                $product_data.="</div></div></div></div></div>";
                $product_data.='<div id="product_desc"><h3><b> OPIS PRODUKTU:</b></h3><b>Marka: </b> '.$product_data_array[5].'<br>';
                $product_data.=$product_data_array[4]."</div>";

                }
        }
        catch(Exception $e)
        {
            $product_data="Błąd<br>Operacja została zatrzymana";
        }
    }
    else
    {
        $product_data="<h2>Nie wskazano produktu</h2>";
    }
}
mysqli_close($link);

?>

<!DOCTYPE html>
<head lang="pl">
    <title>M Apteka</title>
    <meta charset="UTF-8">
    <meta name="description" content="Skep z asortymentem medycznym.Odwiedz nas i bądź zdrowy jak ryba.">
    <link rel="shortcut icon" href="images/pill.png" />
    <meta name="keywords" content="Apteka,pharmacy,leki,chemia,bandaż,syrop,tabletki,choroby,przeziebienie">
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
<div id="cover"></div>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-sm-2 menu_bar" style="position:fixed;padding:0;">
            <a href="index.php" id="a_logo">
                <div class="logo">
                    <img class="img_logo" src="images/rsz_logo.png" alt="Logo Apteki"><br/>
                        M Apteka
                </div>
            </a>
            <div class="menu_options">
                <a href="index.php" style="color:white; text-decoration:none;"><span data-title="Strona główna"><div class="icon-home-outline menu_option" id="home"></div></span></a>
                <span data-title="Twoje Konto"><a href="user.php" style="color:white; text-decoration:none;"><div class="icon-user-o menu_option" id="user" ></div></a></span>
                <span data-title="Koszyk"><a href="user_basket.php" style="color:white; text-decoration:none;"><div class="icon-cart-plus menu_option"></div></a></span>
                <span data-title="Kontakt"><a href="contact_us.php" style="color:white; text-decoration:none;"><div class="icon-mail menu_option" id="contact"></div></a></span>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2" >
            <noscript><div class="no_script">Twoja przeglądarka ma wyłączoną obsługę skryptów JavaScript.</div></noscript>
            <div class="row search_bar">
                <div class="col-sm-3" style="padding:20px">
                    <?php
                        if(!empty($admin_button)) echo $admin_button;
                    ?>
                </div>
                <div class="col-sm-6">
                    <form method="POST" autocomplete="off" action="search.php">
                        <input class="search_input" name="search_input" type="text" name="search" placeholder="Szukaj" >
                    </form>
                </div>
                <div class="col-sm-3" style="padding-top:20px;" >
                    <form action="logout.php" method="POST">
                        <?php
                            if(!empty($logout_button)) echo $logout_button;
                        ?>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="product_info">
                    <div id="product_answer_box" style="color:orange;height:40px;"></div>
                    <?php

                        if(!empty($product_data))
                            echo $product_data;
                    ?>
                </div>
            </div> 
        </div>
    </div>
</div>   

<script>
     
    
$(document).ready(function()
{       
    if(document.cookie.indexOf("show_logout_info") >= 0)
    {
        document.cookie = 'show_logout_info=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        $('body').append('<div id="my_alert">Wylogowano pomyslnie<br><button id="alert_button" type="button">OK</button></div>');
        $("#cover").css('display','block'); 
        
        $(document).on('click','#alert_button',function(){
            $("#cover").css('display','none');
            $('#my_alert').remove();
        });
    }

    $('#order_button').on('click',function() {
        try
        {
            var xhttp;
            var product_quantity_info=$(".product_info1");
            var answerBox=$("#product_answer_box");
            var product_id_box=$("#product_id");
            var product_quantity_box=$("#product_input");
            
            if(!product_quantity_info || !answerBox || !product_id_box || !product_quantity_box)
                throw "Brak elementów html";
           
            
            var product_id=$("#product_id").val();
            var product_quantity=product_quantity_box.val();
            
            if(isNaN(product_quantity)) 
                throw "To nie jest liczba";
            else
                {
                    if(product_quantity<0)
                        throw "Za mała ilość";
                    else if(product_quantity%1 != 0)
                        throw "Produkty kupujemy w całości";
                }

            
            
            
            console.log(product_id);
            console.log(product_quantity);
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
                    product_purchased("Nie możesz dodać produktu do koszyka");
                    answerBox.text("Nie możesz dodać produktu do koszyka");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else if(this.responseText=='Problem z połączeniem z bazą danych')
                {
                    product_purchased('Problem z połączeniem z bazą danych');
                }
                else
                {
                    answerBox.text("Dodano produkt do koszyka");
                    product_purchased("Dodano produkt do koszyka");
                    product_quantity_info.html("Dostępnych sztuk: <b>"+this.responseText+"</b>");     
                }

            }
            };
            xhttp.open("POST", "insert_to_basket.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("product_id="+product_id+"&"+"product_quantity="+product_quantity);
        }
        catch(err)
        {
            product_purchased(err);
            
                answerBox.text("");
        }
        
    });
 
    
    $('#rate_button').on('click',function() {
        try
        {
            var xhttp;
            var product_id=$("#product_id");
            var rate=$("#rate_input");
            var rate_div=$("#rate_div");
            var answerBox=$("#product_answer_box");
            
            if(!product_id || !rate || !rate_div || !answerBox)
                throw "Brak elementów html";
            
            
            
            if(isNaN(rate.val())) 
                throw "To nie jest liczba";
            else
                if(Number(rate.val()))
                {
                    if(rate>10 || rate<1)
                        throw "Niewłaściwa liczba";
                }
            
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
                    product_purchased("Błąd, opreacja nie została wykonana!");
                    answerBox.text("Błąd, opreacja nie została wykonana!");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else if(!isNaN(this.responseText))
                {
                    rate_div.text(parseFloat(this.responseText).toFixed(2));
                    answerBox.text("Dziękujemy za Twoją ocenę!");
                    product_purchased("Dziękujemy za Twoją ocenę!");
                }
                else
                {
                    answerBox.text(this.responseText) ;
                }

            }
            };
            xhttp.open("POST", "give_grade.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("rate_val="+rate.val()+"&product_id="+product_id.val());
        }
        catch(err)
        {
            product_purchased(err);
            if(!answerBox)
                answerBox.text("");
        }
        
    });
    
    
    
    $('#delete_button').on('click',function() {
        
        var x=confirm("Czy napewno chcesz usunąć ten produkt?");
        
        if(x==false)
            return; 
        
        try
        {
            var xhttp;
            var answer_box=$("#product_answer_box");

            if(!$('#delete_button') || !answer_box)
                    throw "Brak elementów html";
            
            var product_id=$('#delete_button').val();
            
            
            
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
                    product_purchased("Nie można usunąć produktu");
                    answerBox.text("Nie można usunąć produktu");
                }
                else if(this.responseText=="redirect")
                {
                    window.location="login.php";
                }
                else if(this.responseText=="ok")
                {
                    setTimeout(function() {
                       window.location="index.php";
                    }, 2000);
                    
                    console.log("Usunięto produkt");
                    product_purchased("Usunięto produkt");
                    
                }

            }
            };
            xhttp.open("POST", "delete_product.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("product_id="+product_id);
        }
        catch(err)
        {
            alert("Błąd, operacja została przerwana");
        }
    });
});
</script> 
</body>
</html>