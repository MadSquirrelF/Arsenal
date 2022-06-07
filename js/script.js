let navbar = document.querySelector('.navbar');
let Cart = document.querySelector('.cart');
let seacrhForm = document.querySelector('.search-form');
let Find = document.querySelector('.find-container');
let personForm = document.querySelector('.person');
let loginFrom = document.querySelector('.login-form');
let loginpopup = document.querySelector('.login-popup');
let updatepopup = document.querySelector('.update_user-popup');
let registerpopup = document.querySelector('.register-popup');

document.querySelector('.login-popup__close').onclick = () =>{
  loginpopup.classList.remove('active');
}
document.querySelector('.register-popup__close').onclick = () =>{
  registerpopup.classList.remove('active');
}
document.querySelector('.update_user-popup__close').onclick = () =>{
  updatepopup.classList.remove('active');
}
document.querySelector('.person').onclick = () => {
  loginFrom.classList.toggle('active');
  navbar.classList.remove('active');
  Find.classList.remove('active');
  seacrhForm.classList.remove('active');
}
document.querySelector('.update_data').onclick = () =>{
  updatepopup.classList.toggle('active');
}
document.querySelector('.signup').onclick = () =>{
  registerpopup.classList.toggle('active');
}

document.querySelector('.signin').onclick = () =>{
  loginpopup.classList.toggle('active');
}
document.querySelector('.menutoogle').onclick = () =>{
    navbar.classList.toggle('active');
    seacrhForm.classList.remove('active');  
    Find.classList.remove('active');
    loginFrom.classList.remove('active');
   
}
document.querySelector('.find-container').onclick = () => {
    seacrhForm.classList.toggle('active');
	navbar.classList.remove('active');
    Find.classList.toggle('active');
    loginFrom.classList.remove('active');
}

document.querySelectorAll('.cart-container .cart').forEach(cart => {
    cart.onclick = () => {
        cart.classList.toggle('active');
    }
})
$(document).ready(function(e){
    $('.btn').on('mouseenter', function(e){
        x = e.pageX - $(this).offset().left;
        y = e.pageY - $(this).offset().top;
        $(this).find('span').css({top:y,left:x})
    });
    $('.btn').on('mouseout', function(e){
      x = e.pageX - $(this).offset().left;
      y = e.pageY - $(this).offset().top;
      $(this).find('span').css({top:y,left:x})
  });
});
let calcScrollValue = () =>{
    let scrollProgress = document.getElementById("progress");
    let progressValue = document.getElementById("progress-value");
    let pos = document.documentElement.scrollTop;
    let calcHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let scrollValue = Math.round((pos * 100)/ calcHeight);
    if(pos > 100){
        scrollProgress.style.display = "grid";
        
    }else{
        scrollProgress.style.display = "none";
        
    }
    scrollProgress.addEventListener("click", () => {
        document.documentElement.scrollTop = 0;
    });
    scrollProgress.style.background = `conic-gradient(#D0BD7D ${scrollValue}%, #d7d7d7  ${scrollValue}%)`;
};
window.onscroll = calcScrollValue;
window.onload = calcScrollValue;

$(function(){
  var activeheader = 100;
   $(window).scroll(function() {
     var scroll = getCurrentScroll();
       if ( scroll >= activeheader ) {
            $('.header').addClass('active');
         }
         else {
             $('.header').removeClass('active');
         }
   });
 function getCurrentScroll() {
     return window.pageYOffset || document.documentElement.scrollTop;
     }
 });
