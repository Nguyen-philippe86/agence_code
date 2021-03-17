// NavBar Burger
const mainMenu = document.querySelector('.mainMenu');
const closeMenu = document.querySelector('.closeMenu');
const openMenu = document.querySelector('.openMenu');

openMenu.addEventListener('click',show);
closeMenu.addEventListener('click',close);

function show(){
    mainMenu.style.display = 'flex';
    mainMenu.style.top = '0';
}
function close(){
    mainMenu.style.top = '-100%';
}
// Contact cacher
$(document).ready(function(){  
    $("#b2").click(function(){
        $(".showContact").toggle(500);
    });
});
// Carroussel
$(function(){
    setInterval(function(){
        $(".slideshow ul").animate({marginLeft:-350},800,function(){
            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
        })
    }, 3500);
});

/* Menu Burger
HTML:
<div id="clickme">Click here</div>
<img id="book" src="book.png" alt="" width="100" height="123">

JQUERY:
$( "#clickme" ).click(function() {
    $( "#book" ).slideToggle( "slow", function() {});
}); 
*/


