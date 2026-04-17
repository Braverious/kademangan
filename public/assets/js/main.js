// Highlight nav active saat scroll
(function(){
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.navbar .nav-link');


function onScroll(){
let current = '';
sections.forEach(sec => {
const top = window.scrollY;
const offset = sec.offsetTop - 120;
const height = sec.offsetHeight;
if (top >= offset && top < offset + height) {
current = sec.getAttribute('id');
}
});
navLinks.forEach(link => {
link.classList.remove('active');
if (link.getAttribute('href') === '#' + current) {
link.classList.add('active');
}
});
}


window.addEventListener('scroll', onScroll);
})();