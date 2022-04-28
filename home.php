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
<div class="navbar">
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

<!-- Début section des annonces -->
<div class="content">
    <section class="latest" id="latest">
        <h2>Dernières annonces</h2>
        <div>
            <?php
            echo "<a href='annonce.php'>
                <article class='article'>
                    <img src=\"imgs/renault-juvaquatre-gea6b628bd_1920.jpg\" alt=\"photo renault juvaquatre\" width=\"200\">
                    <h3>Renault Juvaquatre à <br/>rénover</h3>
                    <p>125€</p>
                </article>
              </a>";
            ?>
            <article class="article">
                <img src="imgs/rottweiler.jpg" alt="photo de chiot race Rottweiler" width="200">
                <h3>Chiot Rottweiler</h3>
                <p>350€</p>
            </article>
        </div>
    </section>

    <!-- Fin section des annonces -->

    <!-- Formulaire de Recherche-->
    <form name="research" class="rechercher" action="home.php" method="POST">
        <h2>Vous recherchez quelque chose ?</h2>
        <label>
            <input type="text" class="search-barre" name="nom">
        </label>
        <br/>
        <div class="tri">Trié par :
            <label>
                date <input type="radio" name="tri" value="date" checked="checked">
            </label>
            <label>
                prix <input type="radio" name="tri" value="prix">
            </label>
            et classé par ordre :
            <label>
                croissant: <input type="radio" name="ordre" value="ASC" checked="checked">
            </label>
            <label>
                décroissant: <input type="radio" name="ordre" value="DESC">
            </label>
        </div>
        <label>
            <button type="submit">rechercher</button>
        </label>
    </form>
    <!-- Fin du Formulaire de recherche -->


    <!-- Fin section des annonces -->

    <?php
    function affiche_annonce($annonce, $nom_u, $prenom_u)
    {
        echo '<article>';
        echo '<form method="POST" action="annonce.php">';
        echo '<img src="' . $annonce['image1'] . '" width="200">';
        echo '<br/>';
        echo '<label>' . $annonce['nom'] . '</label>';
        echo '<br/>';
        echo '<label>' . $annonce['prix'] . ' €</label>';
        echo '<br/>';
        echo '<label>' . $prenom_u . ' ' . $nom_u . '</label>';
        echo '<br/>';
        echo '<label>' . date($annonce['date_post']) . '</label>';
        echo '<br/>';
        echo '<label><button type="submit" name="id_annonce" value="' . $annonce['id'] . '">Consulter</label>';
        echo '</form>';
        echo '</article>';
    }


    if (isset($_POST['ordre']) && isset($_POST['tri']) && isset($_POST['nom'])) {
        include("includes/connex.inc.php");
        $pdo = connexion('bdd.db');
        try {
            if ($_POST['tri'] === 'date')
                $tri = 'date_post';
            if ($_POST['tri'] === 'prix')
                $tri = 'prix';
            $ordre = 'ASC';
            if ($_POST['ordre'] === 'DESC')
                $ordre = 'DESC';

            $req = $pdo->prepare("SELECT * FROM annonce_p WHERE nom LIKE :nom_rechercher ORDER BY $tri $ordre");
            $nom_recherche = '%' . $_POST['nom'] . '%';
            $req->bindParam(':nom_rechercher', $nom_recherche);
            $req->execute();
            $liste_annonce = $req->fetchAll(PDO::FETCH_ASSOC);
            echo '<section class="result">';
            if (count($liste_annonce) == 0)
                echo '<h2>Aucune annonce ne correspond à votre recherche</h2>';
            else if (count($liste_annonce) == 1) {
                echo '<h2>Résultat de votre recherche</h2>';
                echo '<p>' . count($liste_annonce) . ' annonce correspond. </p>';
            } else {
                echo '<h2>Résultats de votre recherche</h2>';
                echo '<p>' . count($liste_annonce) . ' annonces correspondent. </p>';
            }
            echo '<div>';
            foreach ($liste_annonce as $annonce) {
                $req2 = $pdo->prepare("SELECT prenom, nom FROM user WHERE id LIKE :id_u");
                $id_u = $annonce['id_u'];
                $req2->bindParam(':id_u', $id_u);
                $req2->execute();
                $info_user = $req2->fetchAll(PDO::FETCH_ASSOC);
                $user = $info_user[0];
                $nom_u = $user['nom'];
                $prenom_u = $user['prenom'];

                affiche_annonce($annonce, $nom_u, $prenom_u);

                $req2->closeCursor();
            }
            echo '</div>';
            echo '</section>';
            $req->closeCursor();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo '<p>Problème avec la base</p>';
        }

    }
    ?>

    <?php
    if (isset($_SESSION['pseudo']) && isset($_SESSION['statut'])) {
        echo '<section class="recommend" id="recommend">';
        echo '<h2>Recommandé pour vous</h2>';
        echo '</section >';
    }
    ?>
    <!-- Pied de page -->
    <footer>
        <img src="imgs/coing_so.svg" alt="Logo du site" width="90">
        <p class="w7">2022 Le bon Coing Inc.</p>
        <ul>
            <li><a href="#news">informations</a></li>
            <li><a href="sources.html">sources</a></li>
        </ul>
    </footer>
</div>
<script src="js/mesfonctions.js"></script>
</body>
</html>