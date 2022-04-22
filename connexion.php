<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

function afficheFormulaire($p)
{
    $champ = "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method = \"POST\">";
    $champ .= "<h1>Connexion</h1>";
    $champ .= "<label><b> Nom d'utilisateur</b></label>";
    $champ .= "<input type=\"text\" placeholder=\"Entrer le nom d'utilisateur\" name=\"pseudo\" required value=\"" . $p . "\"/>";
    $champ .= "<label><b>Mot de passe</b></label>";
    $champ .= "<input type=\"password\" placeholder=\"Entrer le mot de passe\" name=\"mdp\" required>";
    $champ .= "<input type=\"submit\" id='submit' value='LOGIN'>";
    $champ .= "<a href='inscription.php'>Pas encore membre ? Devenez le !</a>";
    $champ .= "</form>";
    echo $champ;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>Connexion Le bon Coing</title>
    <link rel="stylesheet" href="css/connexion.css" media="screen" type="text/css"/>

    <!-- Pour importer les polices depuis Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Karla:wght@500&display=swap');
    </style>
</head>
<body>
<div id="container">
    <?php
    if (isset($_SESSION['pseudo']) || isset($_SESSION['statut'])) {
        echo "<p>Erreur vous êtes déjà connecté !</p>";
    } else {
        if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
            $ok = 1;
            $pseudo = trim($_POST['pseudo']);
            $mdp = trim($_POST['mdp']);

            include('includes/connex.inc.php');
            $pdo = connexion('bdd.db');

            try {
                $verifpseudo = $pdo->prepare('SELECT * FROM user WHERE pseudo = :pseudo');
                $verifpseudo->bindParam(':pseudo', $pseudo);
                $verifpseudo->execute();
                $res = $verifpseudo->fetchAll(PDO::FETCH_ASSOC);
                if (count($res) > 0) {
                    foreach ($res as $re) {
                        if (strcmp($re['pseudo'], $_POST['pseudo']) == 0) {
                            if (strcmp($re['mdp'], md5($mdp)) == 0) {
                                $ok = 0;
                                $_SESSION['pseudo'] = $pseudo;
                                if (intval($re['statut']) == 0)
                                    $_SESSION['statut'] = "utilisateur";
                                else
                                    $_SESSION['statut'] = "admin";
                            }
                            header('Location:home.php');
                        }
                    }
                }
                if ($ok == 1) {
                    afficheFormulaire("erreur de pseudo ou de mdp");
                }
            } catch (PDOException $exception) {
                echo $exception->getMessage();
                echo '<p>Problème avec la base</p>';
            }
        } else {
            afficheFormulaire(null);
        }
    }
    ?>
</div>
</body>
</html>