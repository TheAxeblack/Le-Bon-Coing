<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


function afficherFormulaire($p)

{
    $champ = '<form class="depos_annonce" action="' . $_SERVER['PHP_SELF'] . '" method="post" enctype="multipart/form-data">';

    $champ .= '<p><label>Titre de l\'annonce: <input type="text" name="nom" required="required"</label><br>';

    $champ .= '<label>Categorie :
                <select name="type" required="required">
                <option value="all">Tout</option>
                <option value="electromenage">Electroménagé</option>
                <option value="informatique">Informatique</option>
                <option value="mobilier">Mobilier</option>
                <option value="immobilier">Immobilier</option>
                <option value="vacance">Vacance</option>
                <option value="multimedia">Multimédia</option>
                </select>
                </label><br>';

    $champ .= '<label> Prix : <input type="text" name="prix" required="required"></label><br>';
    $champ .= '<label> Code postal : <input type="text" name="c_postal" maxlength="5" required="required" ></label><br>';
    $champ .= '<label> Description : </label><br>';
    $champ .= '<textarea type="text" name="description" rows="10" cols="50" required="required" > </textarea>';
    $champ .= '<p><input type="hidden" name="MAX_FILE_SIZE" value="1000000">';
    $champ .= '<label>Ajouter une image : <input type="file" name="image1" accept="image/jpeg"/ required="required" /></label><br>';
    $champ .= '<label>Ajouter une image : <input type="file" name="image2" accept="image/jpeg"/> </label><br>';
    $champ .= '<label>Ajouter une image : <input type="file" name="image3" accept="image/jpeg"/> </label><br>';
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
<div class="navbar">
    <div class="dropdown">
        <button class="dropbtn" onclick="deroulerMenu('myDropdown')">
            <img src="imgs/hamburger.png" alt="icone de menu" width="30" height="30">
        </button>
        <div class="dropdown-content" id="myDropdown">
            <a href="#latest">Dernières annonces</a>
            <a href="#recommend">Les plus consultées</a>
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

<!-- Début section de dépot d'annonce -->
<div class="form-depot">
    <h2> Déposer une annonce</h2>

    <?php

    if (isset($_SESSION['pseudo'])) {

        $message = NULL;
        $fichier2 = NULL;
        $fichier3 = NULL;

        /* IMAGE 1 */

        if (isset($_FILES['image1'])) {

            if ($_FILES['image1']['error'] == 0) {
                $path = "images/";
                if (!is_dir($path)) {
                    mkdir($path);
                }
                $fichier1 = $path . basename($_FILES['image1']["name"]);


                if (file_exists($fichier1)) {
                    $message = "Erreur d'insertion du fichier 1, veuillez renommer l'image.";
                }

                if (!file_exists($fichier1)) {
                    $resultat1 = move_uploaded_file($_FILES['image1']['tmp_name'], $fichier1);


                    if ($resultat1) {
                        $message = "L'image $fichier1 a été ajouté.";
                    } else {
                        $message = "Echec de l'ajout.";
                    }
                }
            } else {
                $message = "Erreur fichier 1, Veuillez réessayer.";
            }
        }

        /* IMAGE 2 */
        if (isset($_FILES['image2'])) {
            if ($_FILES['image2']['error'] == 0) {
                if (!is_dir($path)) {
                    mkdir($path);
                }
                $fichier2 = $path . basename($_FILES['image2']["name"]);
                if (file_exists($fichier2)) {
                    $message = "Erreur d'insertion du fichier 2, veuillez renommer l'image.";
                }
                if (!file_exists($fichier2)) {
                    $resultat2 = move_uploaded_file($_FILES['image2']['tmp_name'], $fichier2);
                    if ($resultat2) {
                        $message = "L'image $fichier2 a été ajouté.";
                    } else {
                        $message = "Echec de l'ajout.";
                    }
                }
            }
            if ($_FILES['image2']['error'] == 2) {
                $message = "L'image est trop lourde.";
            }
        }

        /* IMAGE 3 */

        if (isset($_FILES['image3'])) {
            if ($_FILES['image3']['error'] == 0) {
                if (!is_dir($path)) {
                    mkdir($path);
                }
                $fichier1 = $path . basename($_FILES['image3']["name"]);
                if (file_exists($fichier3)) {
                    $message = "Erreur d'insertion du fichier 3, veuillez renommer l'image.";
                }
                if (!file_exists($fichier3)) {
                    $resultat3 = move_uploaded_file($_FILES['image1']['tmp_name'], $fichier3);
                    if ($resultat3) {
                        $message = "L'image $fichier3 a été ajouté avec suucès !";
                    } else {
                        $message = "Echec de l'ajout.";
                    }
                }
            }
            if ($_FILES['image3']['error'] == 2) {
                $message = "L'image est trop lourde.";

            }
        }

        if ($message) {
            echo $message;
        }

        if (isset($_POST['nom']) && isset($_POST['c_postal']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['type'])) {
            $pseudo = trim($_SESSION['pseudo']);
            $type = trim($_POST['type']);
            $titre = trim($_POST['nom']);
            $c_postal = trim($_POST['c_postal']);
            $prix = trim($_POST['prix']);
            $description = trim($_POST['description']);

            include('includes/connex.inc.php');
            $pdo = connexion('bdd.db');

            try {


                $req = $pdo->prepare('SELECT *  FROM user WHERE pseudo LIKE :pseudo');
                $req->bindParam(':pseudo', $pseudo);
                $req->execute();

                $req2 = $req->fetchAll(PDO::FETCH_ASSOC);
                $info_req = $req2[0];
                $id_u = $info_req['id'];


                $stmt = $pdo->prepare('INSERT INTO annonce_p (id_u,nom,type,date_post,image1,image2,image3,description,prix,c_postal) VALUES(:id_u, :nom, :type,CURRENT_TIMESTAMP , :fichier1, :fichier2, :fichier3, :description, :prix, :c_postal)');

                $stmt->bindParam(':id_u', $id_u);
                $stmt->bindParam(':nom', $titre);
                $stmt->bindParam(':c_postal', $c_postal);
                $stmt->bindParam(':fichier1', $fichier1);
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
                $req->closeCursor();
                $stmt->closeCursor();
                $pdo = null;


            } catch (PDOException $e) {
                echo 'Erreur PDO';
                echo $e->getMessage();
            }
        } else {
            echo "<p>Remplissez le formulaire de l'annonce.</p>";


        }
        afficherFormulaire(NULL);
    } else {
        echo "<p> Vous devez être connecter pour déposer une annonce. </p>";

    }

    ?>
</div>

<!-- Pied de page -->
<footer>
    <img src="imgs/coing_so.svg" alt="Logo du site" width="90">
    <p class="w7">2022 Le bon Coing Inc.</p>
    <ul>
        <li><a href="sources.html">sources</a></li>
    </ul>
</footer>
<script src="js/mesfonctions.js"></script>

</body>
</html>
