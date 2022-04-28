<?php


if(isset($_FILES['fichier'])){
    if ($_FILES['fichier']['error'] == 0){
        $path="images/";
        if(!is_dir($path)){
            mkdir($path);
        }
        $nom= $path. basename($_FILES['fichier']["name"]);
        $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'], $nom);
        if($resultat){
            $message = "Image ajoutée";
        }
        else{
            $message = "Échec de l'ajout";
        }
    }

    else{
        $message = "Erreur fichier";
    }
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

function afficherFormulaire($p)
{
    $champ = "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
    
    $champ .= "<p><label>Titre de l'annonce: <input type=\"text\" name=\"titre_annonce\" required=\"required\" /></label><br>";
    
    $champ .= "<label>Date de l'annonce : <input type=\"text\" placeholder=\"01/01/2020\" name=\"date_annonce\" required=\"required\" /></label><br>";

    $champ .= "<label> Type: <input type=\"text\" name=\"type_annonce\"  required=\"required\" /></label><br>";

    $champ .= "<label> Prix : <input type=\"text\" name=\"prix_annonce\" required=\"required\" /></label><br>";

    $champ .= "<label> Code postal : <input type=\"text\" name=\"cd_annonce\" maxlength=\"5\" required=\"required\" /></label><br>";

    $champ .= "<label> Description : </label><br>";

    $champ .= "<textarea type=\"text\" name=\"description\" rows=\"10\" cols=\"50\" required=\"required\" /> </textarea>";

    $champ .="</p></form>";

    $champ .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" enctype=\"multipart/form-data\">";
    $champ .= "<p><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\">";
    $champ .= "<label>Ajouter une image : <input type=\"file\" name=\"fichier1\" accept=\"image/jpeg\"/ required=\"required\" /></label><br>";
    $champ .= "<label>Ajouter une image : <input type=\"file\" name=\"fichier2\" accept=\"image/jpeg\"/> </label><br>";
    $champ .= "<label>Ajouter une image : <input type=\"file\" name=\"fichier3\" accept=\"image/jpeg\"/> </label><br>";
    $champ .= "<input type=\"submit\" value=\"Ajouter\" /></p>";
    $champ .= "</form>";

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

	<h2> Déposer une annonce</h2>
	<br/>

	<?php
        
        if(isset($_SESSION['pseudo'])) {

	    echo "<p> Vous devez être connecter pour déposer une annonce. </p>";
	    
        }
        else{
	    if (isset($_POST['date_annonce']) && isset($_POST['titre_annonce']) && isset($_POST['cd_annonce']) && isset($_POST['description']) && isset($_POST['prix_annonce']) && isset($_POST['type_annonce']) && isset($_POST['fichier1']) && isset($_POST['fichier2']) && isset($_POST['fichier3'])) {
		
		$date_annonce = trim($_POST['date_annonce']);
		$type_annonce = trim($_POST['type_annonce']);
		$titre_annonce = trim($_POST['titre_annonce']);
		$cd_annonce = trim($_POST['cd_annonce']);
		$fichier1 = trim($_POST['fichier1']);
		$fichier2 = trim($_POST['fichier2']);
		$fichier3 = trim($_POST['fichier3']);
		$prix_annonce = trim($_POST['prix_annonce']);
		$description = trim($_POST['description']);
		
		include('includes/connex.inc.php');
		$pdo = connexion('bdd.db');

		try {
		    $stmt = $pdo->prepare('INSERT INTO annonce_p (id_u,nom,type,date_post,image1,image2,image3,description,prix,c_postal) VALUES(:pseudo, :titre_annonce, :date_annonce, :fichier1, :fichier2, :fichier3, :description, :prix_annonce, :cd_annonce)');
		    $stmt->bindParam(':titre_annonce', $titre_annonce);
		    $stmt->bindParam(':date_annonce', $date_annonce);
		    $stmt->bindParam(':cd_annonce', $cd_annonce);
		    $stmt->bindParam(':fichier1', $fichier1);
		    $stmt->bindParam(':pseudo', $pseudo);
		    $stmt->bindParam(':fichier2', $fichier2);
		    $stmt->bindParam(':fichier3', $fichier3);
		    $stmt->bindParam(':description', $description);
		    $stmt->bindParam(':prix_annonce', $prix_annonce);
		    $stmt->bindParam(':type_annonce', $type_annonce);
		    
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
	    }
	    else {
		echo "<p>Remplissez le formulaire de l'annonce.</p>";
		
	    }
	    
	    afficherFormulaire(NULL);
	    
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
