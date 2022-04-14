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
    $champ .= "<label>Par téléphone <input type=\"tel\" name=\"telephone\" pattern=\"[0-9]{2}.[0-9]{2}.[0-9]{2}.
               [0-9]{2}.[0-9]{2}\" maxlength=\"14\" placeholder=\"06.11.22.33.44\" required=\"required\"><br/>";
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
</head>
<body>
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
        $pdo = connex('tp8');

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
                $stmt = $pdo->prepare('INSERT INTO membres(pseudo, mdp, statut) VALUES (:pseudo, :pass, :statut)');
                $stmt->bindParam(':pseudo', $ps);
                $stmt->bindParam(':pass', $mdp);
                $stmt->bindParam(':statut', $ok);
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