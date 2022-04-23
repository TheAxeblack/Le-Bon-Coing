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

    <!-- Pour importer la police depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
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
        <a href="#home">Le bon Coing</a>
    </div>
    <a href="#"><img src="imgs/more.png" alt="icone ajout" width="30"> Déposer une annonce</a>
    <a href="#logging"><img src="imgs/user.png" alt="icone de compte" width="30"></a>
    <form>
        <label>
            <input type="text" name="search" placeholder="Search..">
        </label>
    </form>
</div>
<?php
function affichage($image1, $image2, $image3, $nom_annonce, $date_post, $description, $prix, $nom_vendeur, $prenom_vendeur, $email_vendeur)
{
    $annonce = '<img src=' . $image1 . '>';
    $annonce .= '<div class="image_secondaire">';
    $annonce .= '<img src=' . $image2 . '>';
    $annonce .= '<img src=' . $image3 . '>';
    $annonce .= '</div>';
    $annonce .= '<h1>' . $nom_annonce . '</h1>';
    $annonce .= $date_post . ' ' . $prix;
    $annonce .= '<p>' . $description . '</p>';
    echo $annonce;
}

if (isset($_POST['id_annonce'])) {
    include("connex.inc.php");
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
</body>
</html>
<!--Fin barre navigation-->
<!---Annonce du vendeur--->
