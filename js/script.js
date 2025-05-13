const navbarToggle = document.querySelector('.navbar-toggle');
const navbarMenu = document.querySelector('.navbar-menu');

navbarToggle.addEventListener('click', () => {
  navbarToggle.classList.toggle('active');
  navbarMenu.classList.toggle('active');
});

document.getElementById('navbar-toggle').addEventListener('click', function() {
  var menu = document.getElementById('navbar-menu');
  menu.classList.toggle('active');
});