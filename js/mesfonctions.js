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

function montrerFormulaire() {
    var form = document.getElementById('contact');
    form.style.display = "block";
}

/* Pour avoir une barre de navigation fixe*/
var navbar = document.querySelector(".navbar");
var sticky = navbar.offsetTop;

function fixerBarre() {
    if (window.scrollY > sticky) {
        navbar.classList.add("sticky");
    } else
        navbar.classList.remove("sticky");
}

window.addEventListener('scroll', fixerBarre);


