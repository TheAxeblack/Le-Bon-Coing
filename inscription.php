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
      $champ .= "<label>Nom : <input type=\"text\" name=\"nom\" placeholder=\"Nom...\" required=\"required\"></label><br/>";
      $champ .= "<label>Prénom :<input type=\"text\" name=\"prenom\" placeholder=\"Prenom...\" required=\"required\"></label><br/>";
      $champ .= "<label>Pseudonyme :
  <input type=\"text\" name=\"pseudo\" value=\"".$p."\" placeholder=\"Pseudonyme...\" required=\"required\">
  </label><br/>";
      $champ .= "<label>Mot de passe :
  <input type=\"password\" name=\"mdp\" placeholder=\"Mot_De_Passe...\" required=\"required\">
  </label><br/>";
      $champ .= "<label>E-mail :
  <input type=\"email\" name=\"email\" placeholder=\"john.doe@mail.us\" required=\"required\">
  </label><br/>";
      $champ .= "<label>Date de naissance <input type=\"text\" name=\"date_n\" maxlength=\"10\" placeholder=\"01/01/1990\" required=\"required\"><br/>";
      $champ .= "<input type=\"submit\" value=\"S'inscrire\" /></p>";
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
              isset($_POST['mdp']) && isset($_POST['date_n']) && isset($_POST['email'])) {
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
                  $stmt = $pdo->prepare('INSERT INTO user (genre,prenom,nom,date_n,pseudo,mdp,email) VALUES(:genre, :prenom, :nom, :date_n, :pseudo, :mdp, :email)');
                  $stmt->bindParam(':genre', $genre);
                  $stmt->bindParam(':prenom', $prenom);
                  $stmt->bindParam(':nom', $nom);
                  $stmt->bindParam(':date_n', $date_n);
                  $stmt->bindParam(':pseudo', $pseudo);
                  $stmt->bindParam(':mdp', $mdp);
                  $stmt->bindParam(':email', $email);
                  
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
              echo "<p>Remplissez le formulaire d'inscription.</p>";
              
          }
          afficheFormulaire(NULL);
          
          
      }
      
    ?>
  </body>
</html>