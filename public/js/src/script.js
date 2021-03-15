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
        $(".showContact").show();
    });
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


