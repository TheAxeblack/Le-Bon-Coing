<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


function afficherFormImage($p)
{
    $champ = '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" enctype="multipart/form-data">';

    $champ .= '<p><input type="hidden" name="MAX_FILE_SIZE" value="1000000">';
    $champ .= '<label>Ajouter une image : <input type="file" name="image1" accept="image/jpeg"/ required="required" /></label><br>';
    $champ .= '<label>Ajouter une image : <input type="file" name="image2" accept="image/jpeg"/> </label><br>';
    $champ .= '<label>Ajouter une image : <input type="file" name="image3" accept="image/jpeg"/> </label><br>';

    $champ .= '<label><input type="submit" value="Ajouter les images"</label>';

    $champ .= '</p></form>';

    echo $champ;

}

function afficherFormulaire($p)
{
    $champ = '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';

    $champ .= '<p><label>Titre de l annonce: <input type="text" name="nom" required="required"</label><br>';

    $champ .= '<label>Date de l annonce : <input type="text" placeholder="01/01/2020" name="date_post" required="required"></label><br>';

    $champ .= '<label> Type: <input type="text" name="type"  required="required"></label><br>';

    $champ .= '<label> Prix : <input type="text" name="prix" required="required"></label><br>';

    $champ .= '<label> Code postal : <input type="text" name="c_postal" maxlength="5" required="required" ></label><br>';

    $champ .= '<label> Description : </label><br>';

    $champ .= '<textarea type="text" name="description" rows="10" cols="50" required="required" > </textarea>';

    $champ .= '<label><input type="submit" value="Ajouter annonce"</label>';

    $champ .= '</p></form>';

    echo $champ;

}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Déposer une annonce</title>
    <link rel="stylesheet" href="css/commun.css">
    <link rel="stylesheet" href="css/accueil.css">


    <!-- Pour importer la police depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
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

<!-- Début section de dépot d'annonce -->

<h2> Déposer une annonce</h2>
<br/>

<?php

if (isset($_SESSION['pseudo'])) {
    $message = NULL;

    afficherFormImage(NULL);

    if (isset($_FILES['image1']) && isset($_FILES['image2']) && isset($_FILES['image3'])) {

        if ($_FILES['image1']['error'] == 0 && $_FILES['image2']['error'] == 0 && $_FILES['image3']['error'] == 0) {
            $path = "images/";
            if (!is_dir($path)) {
                mkdir($path);
            }
            $fichier1 = $path . basename($_FILES['image1']["name"]);
            $fichier2 = $path . basename($_FILES['image2']["name"]);
            $fichier3 = $path . basename($_FILES['image3']["name"]);

            if (file_exists($fichier1)) {
                $message = "Erreur d'insertion du fichier 1, veuillez renommer l'image.";
            }
            if (file_exists($fichier2)) {
                $message = "Erreur d'insertion du fichier 2, veuillez renommer l'image.";
            }
            if (file_exists($fichier3)) {
                $message = "Erreur d'insertion du fichier 3, veuillez renommer l'image.";
            }


            if (!file_exists($fichier1) && !file_exists($fichier2) && !file_exists($fichier3)) {
                $resultat1 = move_uploaded_file($_FILES['image1']['tmp_name'], $fichier1);
                $resultat2 = move_uploaded_file($_FILES['image2']['tmp_name'], $fichier2);
                $resultat3 = move_uploaded_file($_FILES['image3']['tmp_name'], $fichier3);

                if ($resultat1 && $resultat2 && $resultat3) {
                    $message = "Image $fichier1 $fichier1 et $fichier3 ajoutées";
                } else {
                    $message = "Echec de l'ajout.";
                }
            }
        } else {
            $message = "Erreur fichier";
        }


        if ($message) {
            echo $message;
        }
        afficherFormulaire(NULL);


        if (isset($_POST['date_post']) && isset($_POST['nom']) && isset($_POST['c_postal']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['type'])) {

            $message = "JE SUIS LA $fichier1 $ficher2 $ficher3";

            if ($message) {
                echo $message;
            }


            $date_post = trim($_POST['date_post']);
            $type = trim($_POST['type']);
            $titre = trim($_POST['nom']);
            $c_postal = trim($_POST['c_postal']);
            $prix = trim($_POST['prix']);
            $description = trim($_POST['description']);

            include('includes/connex.inc.php');
            $pdo = connexion('bdd.db');

            try {
                $stmt = $pdo->prepare('INSERT INTO annonce_p (id_u,nom,type,date_post,image1,image2,image3,description,prix,c_postal) VALUES(:pseudo, :nom, :date_post, :fichier1, :fichier2, :fichier3, :description, :prix, :c_postal)');
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':date_post', $date_post);
                $stmt->bindParam(':c_postal', $c_postal);
                $stmt->bindParam(':fichier1', $fichier1);
                $stmt->bindParam(':pseudo', $prix);
                $stmt->bindParam(':fichier2', $fichier2);
                $stmt->bindParam(':fichier3', $fichier3);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':prix', $prix);
                $stmt->bindParam(':type', $type);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    echo '<p>Ajout effectué</p>';
                } else {
                    echo '<p>Erreur ajout</p>';
                }
                $stmt->closeCursor();
                $pdo = null;


            } catch (PDOException $exception) {
                echo 'Erreur PDO';
                echo $e->getMessage();
            }
        } else {
            echo "<p>Remplissez le formulaire de l'annonce.</p>";


        }
    }
} else {
    echo "<p> Vous devez être connecter pour déposer une annonce. </p>";

}


?>


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
