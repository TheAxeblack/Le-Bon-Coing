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
    <link rel="stylesheet" href="css/commun.css">
    <link rel="stylesheet" href="css/annonce.css">
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


<?php
function affichage($image1, $image2, $image3, $nom_annonce, $date_post, $description, $prix, $nom_vendeur, $prenom_vendeur, $email_vendeur)
{
    $annonce = '<div class="carouselimgs">';
    $annonce .= '<div class="slide fondu">';
    if ($image2 != null && $image3 != null) {
        $annonce .= '<div class="index">1/3</div>';
        $annonce .= '<img class="slideimg" src=' . $image1 . '>';
        $annonce .= '</div>';
        $annonce .= '<div class="slide fondu">';
        $annonce .= '<div class="index">2/3</div>';
        $annonce .= '<img class="slideimg" src=' . $image2 . '>';
        $annonce .= '</div>';
        $annonce .= '<div class="slide fondu">';
        $annonce .= '<div class="index">3/3</div>';
        $annonce .= '<img class="slideimg" src=' . $image3 . '>';
        $annonce .= '</div>';
        $annonce .= '<a class="precedent" onclick="changerSlide(-1)">&#10094;</a>';
        $annonce .= '<a class="suivant" onclick="changerSlide(1)">&#10095;</a>';
        $annonce .= '</div>'; /* Fin de la <div> carouselimgs */
        $annonce .= '<br/>';
        $annonce .= '<div class="point-slider">';
        $annonce .= '<span class="pt" onclick="slideActuel(1)"></span>';
        $annonce .= '<span class="pt" onclick="slideActuel(2)"></span>';
        $annonce .= '<span class="pt" onclick="slideActuel(3)"></span>';
        $annonce .= '</div>';
    } else if ($image2 != null && $image3 == null) {
        $annonce .= '<div class="index">1/2</div>';
        $annonce .= '<img class="slideimg" src=' . $image1 . '>';
        $annonce .= '</div>';
        $annonce .= '<div class="slide fondu">';
        $annonce .= '<div class="index">2/2</div>';
        $annonce .= '<img class="slideimg" src=' . $image2 . '>';
        $annonce .= '</div>';
        $annonce .= '<a class="precedent" onclick="changerSlide(-1)">&#10094;</a>';
        $annonce .= '<a class="suivant" onclick="changerSlide(1)">&#10095;</a>';
        $annonce .= '</div>'; /* Fin de la <div> carouselimgs */
        $annonce .= '<br/>';
        $annonce .= '<div class="point-slider">';
        $annonce .= '<span class="pt" onclick="slideActuel(1)"></span>';
        $annonce .= '<span class="pt" onclick="slideActuel(2)"></span>';
        $annonce .= '</div>';
    } else {
        $annonce .= '<div class="index">1/1</div>';
        $annonce .= '<img class="slideimg" src=' . $image1 . '>';
        $annonce .= '</div>';
        $annonce .= '</div>'; /* Fin de la <div> carouselimgs */
        $annonce .= '<div class="point-slider">';
        $annonce .= '<span class="pt" onclick="slideActuel(1)"></span>';
        $annonce .= '</div>';
    }
    $annonce .= '<div class="donnees">';
    $annonce .= '<h1>' . $nom_annonce . '</h1>';
    $annonce .= '<p>Prix : <b>' . $prix . '€</b><br/>Annonce mise en ligne le ' . $date_post . '</p>';
    $annonce .= '<p class="description">' . $description . '</p>';
    $annonce .= '</div>';
    echo $annonce;
    $vendeur = '<div class="vendeur">';
    $vendeur .= '<h2> Posté par : ' . $nom_vendeur . ' ' . $prenom_vendeur . '</h2>';
    $vendeur .= '<button id="button_contact" type="button" onclick="montrerFormulaire(\'contact\')">Contacter le vendeur</button>';
    $vendeur .= '<div id="contact">';
    $vendeur .= '<form action="mailto:' . $email_vendeur . '" method="post" enctype="multipart/form-data" name="formcontact">';
    $vendeur .= '<label>Pseudo<input type="text" name="pseudo" id="pseudo" placeholder="Pseudo"></label>';
    $vendeur .= '<br/>';
    $vendeur .= '<label>Sujet<input type="text" name="sujet" id="sujet" value="' . $nom_annonce . '"></label>';
    $vendeur .= '<br/>';
    $vendeur .= '<label>Email<input type="email" name="email" placeholder="Votre email"></label>';
    $vendeur .= '<br/>';
    $vendeur .= '<label>Message<textarea name="msg" placeholder="Votre message"></textarea></label>';
    $vendeur .= '<label><input type="submit" value="envoyer"></label>';
    $vendeur .= '</form>';
    $vendeur .= '</div>';
    echo $vendeur;
    echo '<section class="recommend" id="recommend">';
    echo '<h2>Recommandé pour vous</h2>';

    echo '</section >';
}

if (isset($_POST['id_annonce'])) {
    include("includes/connex.inc.php");
    $pdo = connexion('bdd.db');
    try {
        //Recuperation dans la bdd des info de l'annonce
        $req = $pdo->prepare("SELECT * FROM annonce_p WHERE id LIKE :id_annonce");
        $id_annonce = $_POST['id_annonce'];
        $req->bindParam(':id_annonce', $id_annonce);
        $req->execute();
        $info = $req->fetchAll(PDO::FETCH_ASSOC);
        $info_line = $info[0];
        $image1 = $info_line['image1'];
        $image2 = $info_line['image2'];
        $image3 = $info_line['image3'];
        $nom_annonce = $info_line['nom'];
        $date_post = $info_line['date_post'];
        $description = $info_line['description'];
        $prix = $info_line['prix'];


        //Recuperation dans la bdd des infos de l'utilisateur associé à l'annonce
        $req2 = $pdo->prepare("SELECT * FROM user WHERE id LIKE :id_vendeur");
        $id_vendeur = $info_line['id_u'];
        $req2->bindParam(':id_vendeur', $id_vendeur);
        $req2->execute();
        $info_v = $req2->fetchAll(PDO::FETCH_ASSOC);
        $info_vendeur = $info_v[0];
        $nom_vendeur = $info_vendeur['nom'];
        $prenom_vendeur = $info_vendeur['prenom'];
        $email_vendeur = $info_vendeur['email'];


        //AFFICHAGE DE L'ANNONCE
        echo '<a href="home.php"><img class="rollback" src="imgs/retour.png" alt="icone de retour arrière" width="40px"></a>';
        affichage($image1, $image2, $image3, $nom_annonce, $date_post, $description, $prix, $nom_vendeur, $prenom_vendeur, $email_vendeur);
        //FERMETURE DES CURSEUR
        $req->closeCursor();
        $req2->closeCursor();
        $pdo = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo '<p>Problème avec la base</p>';
    }
} else {
    echo 'Annonce inexistante';
}
?>
<script src="js/carousel.js"></script>
<script src="js/mesfonctions.js"></script>

</body>
</html>
<!--Fin barre navigation-->
<!---Annonce du vendeur--->
