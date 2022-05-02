<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

function afficheFormulaire($p)
{
    $champ = "<div id=\"container\">";
    $champ .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
    $champ .= "<h1>Inscription</h1>";
    $champ .= "<label>Vous êtes :<input type=\"radio\" name=\"genre\" required=\"required\" value=\"homme\">un homme</label>";
    $champ .= "<label><input type=\"radio\" name=\"genre\" required=\"required\" value=\"femme\">une femme</label>";
    $champ .= "<label><input type=\"radio\" name=\"genre\" required=\"required\" value=\"n-b\">Non binaire</label><br/>";
    $champ .= "<label>Vous vous appelez : <input type=\"text\" name=\"nom\" placeholder=\"Nom...\" required=\"required\"></label> ";
    $champ .= "<label><input type=\"text\" name=\"prenom\" placeholder=\"Prenom...\" required=\"required\"></label><br/>";
    $champ .= "<label>Vous souhaitez que les autres vous voient sous le nom de :
  <input type=\"text\" name=\"pseudo\" value=\"" . $p . "\" placeholder=\"Pseudonyme...\" required=\"required\">
  </label><br/>";
    $champ .= "<label>Votre mot de passe (promis vous serez le seul à le connaitre) :
  <input type=\"password\" name=\"mdp\" placeholder=\"Mot_De_Passe...\" required=\"required\">
  </label><br/>";
    $champ .= "<label>Votre adresse mail :
  <input type=\"email\" name=\"email\" placeholder=\"john.doe@mail.us\" required=\"required\">
  </label><br/>";
    $champ .= "<label>Date de naissance <input type=\"text\" name=\"date_n\" maxlength=\"10\" placeholder=\"01/01/1990\" required=\"required\"></label><br/>";
    $champ .= "<label><input type=\"submit\" value=\"Let's go !\"</label>";
    $champ .= "</form>";
    $champ .= "</div>";
    echo $champ;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/insc_conn.css">

    <!-- Pour importer les polices depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Karla:wght@500&display=swap');
    </style>
</head>
<body>
<a class="rollback" href="connexion.php"><img src="imgs/retour.png" alt="icone de retour arrière" width="40px"></a>
<?php
if (isset($_SESSION['pseudo']) || isset($_SESSION['statut'])) {
    echo "<p>Vous ne pouvez pas vous inscrire si vous êtes connecté</p>";
} else {
    if (isset($_POST['genre']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['pseudo']) &&
        isset($_POST['mdp']) && isset($_POST['date_n']) && isset($_POST['email'])) {
        $ok = 1;
        $genre = $_POST['genre'];
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $date_n = trim($_POST['date_n']);
        $pseudo = trim($_POST['pseudo']);
        $mdp = md5(trim($_POST['mdp']));
        $email = trim($_POST['email']);

        include('includes/connex.inc.php');
        $pdo = connexion('bdd.db');

        try {
            $verifpseudo = $pdo->prepare('SELECT (pseudo) FROM user WHERE pseudo = :pseudo');
            $verifpseudo->bindParam(':pseudo', $pseudo);
            $verifpseudo->execute();
            $res = $verifpseudo->fetchAll(PDO::FETCH_ASSOC);
            if (count($res) != 0)
                foreach ($res as $re)
                    if (strcmp($re['pseudo'], $_POST['pseudo']) == 0)
                        $ok = 0;

            if ($ok == 0) {
                echo "<script type=\"javascript\">";
                echo "alert('Le pseudo est déjà utilisé')";
                echo "</script>";
                afficheFormulaire(NULL);
            } else {
                $stmt = $pdo->prepare('INSERT INTO user (genre,prenom,nom,date_n,pseudo,mdp,email) 
                                         VALUES(:genre, :prenom, :nom, :date_n, :pseudo, :mdp, :email)');
                $stmt->bindParam(':genre', $genre);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':date_n', $date_n);
                $stmt->bindParam(':pseudo', $pseudo);
                $stmt->bindParam(':mdp', $mdp);
                $stmt->bindParam(':email', $email);

                $stmt->execute();

                echo "<script type=\"javascript\">";
                if ($stmt->rowCount() == 1) {
                    echo "alert('Ajout effectué')";
                    echo "</script>";
                    header("Location:connexion.php");
                } else {
                    echo "alert('Erreur lors de l'ajout veuillez réessayer')";
                    echo "</script>";
                    afficheFormulaire(null);
                }
                $stmt->closeCursor();
                $pdo = null;
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            echo 'Erreur PDO';
        }
    } else afficheFormulaire(null);
}
?>
</body>
</html>