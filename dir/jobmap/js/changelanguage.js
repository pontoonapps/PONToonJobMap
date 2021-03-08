
$('#translate').click(function() {
    if(Cookies.get('language') == 'en') {
        translator.lang("fr");
        Cookies.set('language', 'fr', { expires: 7 });
    } else if (Cookies.get('language') == 'fr') {
        translator.lang("en");
        Cookies.set('language', 'en', { expires: 7 });  
    }
});

$(document).ready(function(){
    if (Cookies.get('language') == 'en') {
        translator = $('body').translate({lang: "en", t: dict});
    } else if (Cookies.get('language') == 'fr') {
        translator = $('body').translate({lang: "fr", t: dict});
    } else {
        translator = $('body').translate({lang: "en", t: dict});
        Cookies.set('language', 'en', { expires: 7 });   
    }    
});