$(document).ready(function()
{
    function cookie_info()
    {
        $('body').append('<div style="display: none;" class="cookie_info">Ta strona korzysta z plików cookies<button class="cookie_button" type="button">OK</button></div>');
        $(".cookie_info").slideDown("slow");        
    }
    
    if(document.cookie.indexOf('cookie_info_flag')<0)
    {
        setTimeout(cookie_info, 1000);
    }
    
    $(document).on('click',".cookie_button",function(){
        
        if(document.cookie.indexOf('cookie_info_flag')<0)
        {
            document.cookie = 'cookie_info_flag=ok;';
        }     
        $(".cookie_info").slideUp("slow");
    });
    
    console.log('%c Proszę nie grzebać w kodzie! ', 'background: #222; color: #bada55');
    
});    
    function hide_purchased_info()
    {
        $(".product_purchased_info").slideUp("slow");
        setTimeout(function(){$(".product_purchased_info").remove()},1000);
    }
    
    function product_purchased(variable)
    {
        $('body').append('<div style="display:none;" class="product_purchased_info">'+variable+'</div>');
        $(".product_purchased_info").slideDown("slow");
        
        setTimeout(hide_purchased_info,1500);
    }
    
