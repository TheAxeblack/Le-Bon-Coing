<?php
if (isset($_FILES['fichier'])){
    if ($_FILES['fichier']['error'] == 0){
        $path="images/";
        if(!is_dir($path)){
            mkdir($path);
        }
        $tmp = 0;
        $nom= $path.time().'.jpg';
        if($tmp < 3){
            $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'], $nom);
            $tmp ++;
            
            if($resultat){
                $message = "Image ajoutée $tmp";
            }
            else{
                $message = "Échec de l'ajout";
            }
        }
        else {
            $message = "Vous ne pouvez pas ajouté plus de trois images.";
        }
    }
    else{
        $message = "Erreur fichier";
    }
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

            
            
	?>
	    <form id="formulaire">
		
		<br/>
		
		<label>
		    Titre de l'annonce: <input type="text" id="titre_annonce" required/>
		</label>
		
		
	    </form>
	    
	    
	    
	<?php
        }
        else
            /* echo "<p> Vous devez être connecter pour déposer une annonce. </p>" */
            
            if ($message) { echo $message;} ?>
	<form action="deposer_annonce.php" method="POST" enctype="multipart/form-data">
	    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	    <label>Ajouter une image : <input type="file" name="fichier" accept="image/jpeg"/>
	    </label>
	    <br>
	    <button type="submit">Ajouter</button>
	</form>
	<?php
        if($tmp <3) {
            if (is_dir($path)){
                $handle = opendir($path);
                if($handle){
                    do{
                        $file = readdir($handle);
                        if ($file && !in_array($file, [false, '.', '..'])){
                            echo '<img src="'.$path.$file.'" width="150">';
                            /*var_dump($file);*/
                        }
                    }while($file !== false);
                    closedir($handle);
                }
            } else{
                echo "<p>Pas encore d'images</p>";
            }
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
