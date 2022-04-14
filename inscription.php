<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

function afficheFormulaire($p)
{
    $champ = "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
    $champ .= "<p><label>Vous êtes :<input type=\"radio\" name=\"genre\" required=\"required\">un homme</label>";
    $champ .= "<label><input type=\"radio\" name=\"genre\" required=\"required\">une femme</label>";
    $champ .= "<label><input type=\"radio\" name=\"genre\" required=\"required\">Non binaire</label><br/>";
    $champ .= "<label>Vous vous appelez : <input type=\"text\" name=\"nom\" placeholder=\"Nom...\" required=\"required\"></label> ";
    $champ .= "<label><input type=\"text\" name=\"prenom\" placeholder=\"Prenom...\" required=\"required\"></label><br/>";
    $champ .= "<label>Vous souhaitez que les autres vous voient sous le nom de :
                <input type=\"text\" name=\"pseudo\" placeholder=\"Pseudonyme...\" required=\"required\">
               </label><br/>";
    $champ .= "<label>Votre mot de passe (promis vous serez le seul à le connaitre) :
                <input type=\"password\" name=\"mdp\" placeholder=\"Mot_De_Passe...\" required=\"required\">
               </label><br/>";
    $champ .= "<label>Nous pouvons vous joindre :<br/>Par mail 
                <input type=\"email\" name=\"adresse\" placeholder=\"john.doe@mail.us\" required=\"required\">
               </label><br/>";
    $champ .= "<label>Par téléphone <input type=\"tel\" name=\"telephone\" maxlength=\"10\" placeholder=\"06.11.22.33.44\" required=\"required\"><br/>";
    $champ .= "<label><input type=\"checkbox\" name=\"infos\">Souhaitez-vous être mis au courant des nouvelles annonces 
               publiées ?</label><br/><br/>";
    $champ .= "<input type=\"submit\" value=\"Let's go !\" /></p>";
    $champ .= "</form>";
    echo $champ;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/commun.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
    </style>
</head>
<body>
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
            <input class="search-barre" type="text" name="search" placeholder="Search..">
        </label>
    </form>
</div>
<?php
if (isset($_SESSION['pseudo'])) {
    echo "<p>Vous ne pouvez pas vous inscrire si vous êtes connecté</p>";
} else {
    if (isset($_POST['genre']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['pseudo']) &&
        isset($_POST['mdp']) && isset($_POST['adresse']) && isset($_POST['infos'])) {
        $genre = $_POST['genre'];
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $pseudo = trim($_POST['pseudo']);
        $mdp = md5(trim($_POST['mdp']));
        $email = trim($_POST['adresse']);
        $news = $_POST['infos'];

        include('includes/connex.inc.php');
        $pdo = connex("le_bon_coin");

        try {
            $verifps = $pdo->prepare('SELECT (pseudo) FROM utilisateur WHERE pseudo = :ps');
            $verifps->bindParam(':ps', $ps);
            $verifps->execute();
            $res = $verifps->fetchAll(PDO::FETCH_ASSOC);
            if (count($res) == 0) {
                foreach ($res as $pres) {
                    if (strcmp($pres['pseudo'], $_POST['pseudo']) == 0)
                        $ok = 0;
                }
            }
            if ($ok == 0)
                afficheFormulaire("Pseudo déjà utilisé");
            else {
                $stmt = $pdo->prepare('INSERT INTO utilisateur(genre, nom, prenom, pseudo, mdp, email, news) VALUES 
                                                                          (:genre, :nom, :prenom, :pseudo, :pass, :mail, :news)');
                $stmt->bindParam(':genre', $genre);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':pseudo', $pseudo);
                $stmt->bindParam(':pass', $mdp);
                $stmt->bindParam(':mail', $email);
                $stmt->bindParam(':news', $news);
                $stmt->execute();
                echo "<p>Vous avez bien été inscrit.<br><a href=\"connexion.php\">Se connecter</a></p>";
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            echo '<p>Problème avec la base</p>';
        }
    }
    afficheFormulaire(null);
}
?>
</body>
</html>