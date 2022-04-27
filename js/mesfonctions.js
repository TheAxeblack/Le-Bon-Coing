/* Lors de l'appui sur le bouton révèle le menu */
function deroulerMenu(identifiant) {
    document.getElementById(identifiant).classList.toggle("show");
}

/* Ferme le menu déroulant approprié si on clique en dehorns */
window.onclick = function (e) {
    if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
        var myDropdown2 = document.getElementById("myDropdown2");
        var myDropdown3 = document.getElementById("myDropdown3");
        if (myDropdown.classList.contains('show'))
            myDropdown.classList.remove('show');
        if (myDropdown2.classList.contains('show'))
            myDropdown2.classList.remove('show');
        if (myDropdown3.classList.contains('show'))
            myDropdown3.classList.remove(('show'));
    }
}


function choisirLangue() {
    alert('Coucou');
}

function changerMode() {
    var element = document.body;
    var article = document.getElementsByClassName('article');
    element.classList.toggle("dark-mode");
    article.class = "dark-mode-article"
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