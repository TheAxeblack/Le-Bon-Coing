/* Lors de l'appui sur le bouton révèle le menu */
function deroulerMenu(identifiant) {
    document.getElementById(identifiant).classList.toggle("show");
}

/* Ferme le menu déroulant approprié si on clique en dehorns */
window.onclick = function (e) {
    if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
        var myDropdown2 = document.getElementById("myDropdown2");
        if (myDropdown.classList.contains('show'))
            myDropdown.classList.remove('show');
        if (myDropdown2.classList.contains('show'))
            myDropdown2.classList.remove('show');
    }
}


function choisirLangue() {
    alert('Coucou');
}

function changerMode() {
    var element = document.body;
    var form = document.forms.research;
    element.classList.toggle("dark-mode");
    form.classList.toggle("dark-mode-article");
}

/* Pour avoir une barre de navigation fixe*/
var navbar = document.querySelector(".navbar");
var sticky = navbar.offsetTop;

function fixerBarre() {
    if (window.scrollY >= sticky) {
        navbar.classList.add("sticky");
    } else
        navbar.classList.remove("sticky");
}

window.addEventListener('scroll', fixerBarre);


/* Section du carousel d'images */
var index_slide = 1;
montrerSlides(index_slide);

function slider(n) {
    montrerSlides(index_slide += n);
}

function slideActuel(n) {
    montrerSlides(index_slide = n);
}

function montrerSlides(n) {
    var i;
    var slides = document.getElementsByClassName("slide");
    var points = document.getElementsByClassName("pt");
    if (n > slides.length)
        index_slide = 1;
    if (n < 1)
        index_slide = slides.length;
    for (i = 0; i < slides.length; i++)
        slides[i].style.display = "none";
    for (i = 0; i < points.length; i++)
        points[i].className = points[i].className.replace(" active", "");
    slides[index_slide - 1].style.display = "block";
    points[index_slide - 1].className += " active";
}