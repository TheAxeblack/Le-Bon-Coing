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
<div class="content">
    <section>
        <?php

        function affiche_annonce($annonce)
        {
            echo '<div>';
            echo '<article>';
            echo '<form method="POST" action="annonce.php">';
            echo '<img src="' . $annonce['image1'] . '" width="200">';
            echo '<br/>';
            echo '<label>' . $annonce['nom'] . '</label>';
            echo '<br/>';
            echo '<label>' . $annonce['prix'] . ' €</label>';
            echo '<br/>';
            echo '<label><button type="submit" name="id_annonce" value="' . $annonce['id'] . '">Consulter</button></label>';
            echo '</form>';
            echo '<form method="POST" action="supprimer.php">';
            echo '<label><button type="submit" name="supprimer" value="' . $annonce['id'] . '">Supprimer</label>';
            echo '</form>';
            echo '</article>';
            echo '<article class="modif">
        <form method="POST" action="modifier.php" >
            <label>Modifier titre<input type="text" name="nom_annonce"></label>
            <br/>
            <label>Modifier Prix<input type="text" name="prix"></label>
            <br/>
            <label>Modifier desciption<textarea name="description"></textarea></label>
            <br>
            <label><button type="submit" name="id_annonce" value="' . $annonce['id'] . '">Appliquer modification</button></label>
        </form>
        </article>';
            echo '</div>';
        }

        function afficher_user($user_tmp)
        {
            echo '<div>';
            echo '<article>';
            echo '<form action="user_list.php" method="POST">';
            echo '<img src="imgs/user.png" width="200">';
            echo '<br/>';
            echo '<label>' . $user_tmp['nom'] . '</label>';
            echo '<br/>';
            echo '<label>' . $user_tmp['prenom'] . '</label>';
            echo '<br/>';
            echo '<label>' . $user_tmp['email'] . '</label>';
            echo '<br/>';
            if($user_tmp['statut'] == 1)
            {
                echo '<label><button type="submit" name="statut" value="'.$user_tmp['statut'].'">Acceder aux utilisateurs</button></label></br>';
            }
            echo '</form>';
            echo '</article>';
            echo '<article>
            <form method="POST" action="modifier_profil.php" >
            <label>Tout les champs sont obligatoires !</label>
            <br>
            <label>Changer pseudo<br><input type="text" name="pseudo"></label>
            <br>
            <label>Changer e-mail:<br><input type="text" name="email"></label>
            <br>
            <label>Changer mot de passe:<br><input type="password" name="mdp" placeholder="Mot_De_Passe..." required="required">
            </label><br/>
            <br>
            <label><button type="submit" name="id_user" value="' . $user_tmp['id'] . '">Appliquer modification</button></label>
            </form>
            </article>';
            echo '</article>';
            echo '</div>';
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
                echo '<h1>Mon profil</h1>';
                afficher_user($user_tmp);
                echo '<h1>Mes annonces</h1>';
                $liste_annonce = $req2->fetchAll(PDO::FETCH_ASSOC);
                if ($req2->rowCount() == 0)
                 {
                     echo 'Aucune annonce de deposé';
                 }
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

        ?>
    </section>
</div>

<script src="js/mesfonctions.js"></script>
</body>
</html>

