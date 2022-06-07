let profile = document.querySelector('.header .flex .profile');
let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('.user-btn').onclick = () =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}
document.querySelector('.menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}
window.onscroll = () =>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
}