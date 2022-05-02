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
    alert('Fonctionnalité en développement');
}

function changerMode() {
    var element = document.body;
    var header = document.getElementById('header');
    var articles = document.getElementsByTagName('ARTICLE');
    var i;
    var form = document.getElementsByName("research");
    element.classList.toggle("dark-mode");
    if (element.classList.contains("dark-mode"))
        header.style.backgroundImage = "url(imgs/coings_nuit.jpg)";
    else
        header.style.backgroundImage = "url(imgs/coings.jpg)";
    if (articles.length > 0) {
        for (i = 0; i < articles.length; i++) {
            articles[i].classList.toggle("dark-mode-article");
        }
    }
    form.classList.toggle("dark-mode-article");
}

function montrerFormulaire(identifiant) {
    var form = document.getElementById(identifiant);
    form.style.display = "block";
}

