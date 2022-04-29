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

<!-- Début de la barre de navigation -->
<div class="navbar">
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown')">
            <img src="imgs/hamburger.png" alt="icone de menu" width="30" height="30">
        </button>
        <div class="dropdown-content" id="myDropdown">
            <?php
            if (isset($_SESSION['pseudo']) && isset($_SESSION['statut'])) {
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


</body>
<?php
    var_dump($_POST['nom_annonce'], $_POST['prix'], $_POST['description'], $_POST['id_annonce']);
    if(isset($_POST['nom_annonce']) && isset($_POST['prix']) && isset($_POST['description']) && isset($_POST['id_annonce']))
    {
        include("includes/connex.inc.php");
        $pdo = connexion('bdd.db');
        try{
            $req = $pdo->prepare("UPDATE annonce_p
            SET nom = :nom_annonce, prix = :prix, description = :description
            WHERE id LIKE :id_annonce");
            $nom_annonce = $_POST['nom_annonce'];
            $prix = $_POST['prix'];
            $id_annonce = $_POST['id_annonce'];
            $description = $_POST['description'];
            $req->bindParam(":nom_annonce", $nom_annonce);
            $req->bindParam(":prix", $prix);
            $req->bindParam(":description", $description);
            $req->bindParam(":id_annonce", $id_annonce);
            $req->execute();
            $req->closeCursor();
            echo 'Annonce modifier avec succès !'; 
            header('Location:home.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo '<p>Problème avec la base</p>';
        }
    }



?>
</html>