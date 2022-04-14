/* Lors de l'appui sur le button révele le menu */
function deroulerMenu(identifiant) {
    document.getElementById(identifiant).classList.toggle("show");
}

/* Ferme le menu déroulant approprié si on clique en dehors */
window.onclick = function (e) {
    if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
        var myDropdown2 = document.getElementById("myDropdown2");
        var myDropdown3 = document.getElementById("myDropdown3");
        if (myDropdown.classList.contains('show'))
            myDropdown.classList.remove('show');
        else if (myDropdown2.classList.contains('show'))
            myDropdown2.classList.remove('show');
        else if (myDropdown3.classList.contains('show'))
            myDropdown3.classList.remove(('show'));
    }
}

function choisirLangue() {
    alert('Coucou');
}

function changerMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
}


window.onscroll = function () {
    fixerBarre()
};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function fixerBarre() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
    } else {
        navbar.classList.remove("sticky");
    }
}