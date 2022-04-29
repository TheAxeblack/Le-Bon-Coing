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
    <link rel="icon" href="imgs/favicon.ico">
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/commun.css">

    <!-- Pour importer les polices depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Karla:wght@500&display=swap');
    </style>
</head>
<body>

<header id="header"></header>
<!-- Début de la barre de navigation -->
<div id="navbar" class="navbar">
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown')">
            <img src="imgs/hamburger.png" alt="icone de menu" width="30" height="30">
        </button>
        <div class="dropdown-content" id="myDropdown">
            <a href="#latest">Dernières annonces</a>
            <?php
            if (isset($_SESSION['pseudo']) && isset($_SESSION['statut'])) {
                echo '<a href="#recommend">Les plus consultées</a>';
                echo "<a href=\"gestion.php\">Gérer mes annonces</a>";
                echo "<a href=\"deconnexion.php\">Se déconnecter</a>";
            }
            ?>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown2')">
            <img src="imgs/france.png" alt="icone du drapeau français" width="30">
        </button>
        <div class="dropdown-content" id="myDropdown2">
            <img src="imgs/france.png" alt="icone du drapeau français" width="30" onclick="choisirLangue()">
            <img src="imgs/uk.png" alt="icone du drapeau anglais" width="30" onclick="choisirLangue()">
        </div>
    </div>
    <button class="nigthbtn" onclick="changerMode()">
        <img id="mode" src="imgs/sun.png" alt="icone de soleil" width="30" height="30">
    </button>
    <div class="nametag w7">
        <a href="home.php">
            <img src="imgs/coing_so.svg" alt="Logo du site" width="50">
            <h1>Le bon Coing</h1>
        </a>
    </div>
    <a href="deposer_annonce.php"><img src="imgs/more.png" alt="icone ajout" width="30"> Déposer une annonce</a>
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

<h1>Mes annonces</h1>
<?php

function affiche_annonce($annonce)
{
    echo '<article>';
    echo '<form method="POST" action="annonce.php">';
    echo '<img src="' . $annonce['image1'] . '" width="200">';
    echo '<br/>';
    echo '<label>' . $annonce['nom'] . '</label>';
    echo '<br/>';
    echo '<label>' . $annonce['prix'] . ' €</label>';
    echo '<br/>';
    echo '<label><button type="submit" name="id_annonce" value="' . $annonce['id'] . '">Consulter</label>';
    echo '</form>';
    echo '</article>';
    echo '<article>
            <form method="POST" action="modifier.php" >
                <label>Modifier titre<br><input type="text" name="nom_annonce"></label>
                <br>
                <label>Modifier Prix<br><input type="text" name="prix"></label>
                <br>
                <label>Modifier desciption<br><input type="text" name="description" style="width: 300px; height: 150px; "></label>
                <br>
                <label><button type="submit" name="id_annonce" value="' . $annonce['id'] . '">Appliquer modification</button></label>
            </form>
            </article>';
}

function afficher_user($user_tmp)
{
    echo '<article>';
    echo '<form>';
    echo '<img src="imgs/user.png" width="200">';
    echo '<br/>';
    echo '<label>' . $user_tmp['nom'] . '</label>';
    echo '<br/>';
    echo '<label>' . $user_tmp['prenom'] . '</label>';
    echo '<br/>';
    echo '<label>' . $user_tmp['email'] . '</label>';
    echo '<br/>';
    echo '<label><button type="submit" name="modifier_profil" value="' . $user_tmp['id'] . '">Modifier</label>';
    echo '</form>';
    echo '</article>';
}

if (isset($_SESSION['pseudo']) && isset($_SESSION['statut'])) {
    include("includes/connex.inc.php");
    $pdo = connexion('bdd.db');
    try {
        $req = $pdo->prepare("SELECT * FROM user WHERE pseudo LIKE :pseudo");
        $pseudo = $_SESSION['pseudo'];
        $req->bindParam(":pseudo", $pseudo);
        $req->execute();
        $user_info = $req->fetchAll(PDO::FETCH_ASSOC);
        $user_tmp = $user_info[0];
        $user_id = $user_tmp['id'];
        $req2 = $pdo->prepare("SELECT * FROM annonce_p WHERE id_u LIKE :user_id");
        $req2->bindParam(":user_id", $user_id);
        $req2->execute();
        $liste_annonce = $req2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($liste_annonce as $annonce) {
            affiche_annonce($annonce);
        }
        $req->closeCursor();
        $req2->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo '<p>Problème avec la base</p>';
    }
}
afficher_user($user_tmp);
?>


<script src="js/mesfonctions.js"></script>
</body>
</html>

