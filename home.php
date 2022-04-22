<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le bon coing</title>
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/commun.css">

    <!-- Pour importer les polices depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Karla:wght@500&display=swap');
    </style>
</head>
<body>

<!-- Début de la barre de navigation -->
<div class="navbar">
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown')">
            <img src="imgs/hamburger.png" alt="icone de menu" width="30" height="30">
        </button>
        <div class="dropdown-content" id="myDropdown">
            <a href="#">Gérer mes annonces</a>
            <a href="#">Link 3</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown2')">
            <img src="imgs/france.png" alt="icone du drapeau français" width="30">
        </button>
        <div class="dropdown-content" id="myDropdown2">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
        </div>
    </div>
    <button class="nigthbtn" onclick="changerMode()">
        <img src="imgs/sun.png" alt="icone de soleil" width="30" height="30">
    </button>
    <div class="nametag w7">
        <a href="home.php">Le bon Coing</a>
    </div>
    <a href="#"><img src="imgs/more.png" alt="icone ajout" width="30"> Déposer une annonce</a>
    <?php
    if (isset($_SESSION['pseudo']))
        echo "<a href=\"gestion.php\"><img src=\"imgs/user.png\" alt=\"icone de compte\" width=\"30\"></a>";
    else
        echo "<a href=\"connexion.php\"><img src=\"imgs/user.png\" alt=\"icone de compte\" width=\"30\"></a>";
    ?>
    <form>
        <label>
            <input class="search-barre" type="text" name="search" placeholder="Search..">
        </label>
    </form>
</div>
<!-- Fin de la barre de navigation -->

<?php
if (isset($_SESSION['pseudo']) && isset($_SESSION['statut'])) {
    echo "<p>Bonjour, " . $_SESSION['pseudo'] . " <a href=\"deconnexion.php\">Se déconnecter</a></p>";
}
?>

<!-- Début section des annonces -->
<section class="latest">
    <h2>Dernières annonces</h2>
    <div>
        <?php
        echo "<a href='annonce.php'><article><img src=\"imgs/renault-juvaquatre-gea6b628bd_1920.jpg\" alt=\"photo renault juvaquatre\" width=\"200\">
            <h3>Renault Juvaquatre à <br/>rénover</h3><p>125€</p></article></a>";
        ?>
        <article>
            <img src="imgs/rottweiler.jpg" alt="photo de chiot race Rottweiler" width="200">
            <h3>Chiot Rottweiller</h3>
            <p>350€</p>
        </article>
    </div>
</section>

<section class="recommand">
    <h2>Recommandé pour vous</h2>
</section>

<!-- Fin section des annonces -->

<!-- Pied de page -->
<footer>
    <p>2022 Le bon Coing Inc.</p>
    <ul>
        <li><a href="#news">informations</a></li>
        <li><a href="sources.html">sources</a></li>
    </ul>
</footer>
<script src="js/mesfonctions.js"></script>
</body>
</html>