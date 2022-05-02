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
</body>
<?php
    if(isset($_POST['id_user']))
    {
        include("includes/connex.inc.php");
        $pdo = connexion('bdd.db');
        try{
            $req = $pdo->prepare("DELETE FROM user WHERE id LIKE :id_user");
            $id_user = $_POST['id_user'];
            $req->bindParam(":id_user",$id_user);
            $req->execute();
            $req2 = $pdo->prepare("DELETE FROM annonce_p WHERE id_u LIKE :id_user");
            $req2->bindParam(":id_user",$id_user);
            $req2->execute();
            
            $req2->closeCursor();
            $req->closeCursor();
            echo '<script type="javascript">alert("Utilisateur bien supprimé !")'; 
            header('Location:home.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo '<p>Problème avec la base</p>';
        }
    }
?>