<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");

include_once('includes/connex.inc.php');

$pdo = connexion('bdd.db');


$pdo->exec("DROP TABLE user");

$us = "CREATE TABLE IF NOT EXISTS user(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  genre VARCHAR(255),
  prenom VARCHAR(255),
  nom VARCHAR(255),
  date_n DATE,
  pseudo VARCHAR(255),
  mdp VARCHAR(255),
  email VARCHAR(255),
  statut INT DEFAULT 0
)";

$pdo->exec($us);


$pdo->exec("DROP TABLE annonce_p");

$ann = "CREATE TABLE IF NOT EXISTS annonce_p(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  id_u INTEGER,
  nom VARCHAR(255),
  type VARCHAR(255),
  date_post DATE,
  image1 VARCHAR(255) NOT NULL,
  image2 VARCHAR(255),
  image3 VARCHAR(255),
  description VARCHAR(5000),
  prix INT,
  c_postal INT,
  FOREIGN KEY (id_u) REFERENCES user(id) 
)";


$pdo->exec($ann);

$mdp=md5('genshin42');
$stmt=$pdo->prepare("INSERT INTO user (genre, prenom, nom, date_n, pseudo, mdp, email, statut) VALUES ('n-b', 'SuperUser', 'Admin', '2000-01-01', 'SuperUser', :mdp, 'mathislecuyer@gmail.com', 1);");
$stmt->bindParam(':mdp', $mdp);
$stmt->execute();

$mdp3=md5('genshin75');
$stmt3=$pdo->prepare("INSERT INTO user (genre, prenom, nom, date_n, pseudo, mdp, email) VALUES ('femme', 'Lina', 'Benali', '2002-10-10', 'bonsoirlina', :mdp3, 'lina.benali68@gmail.com');");
$stmt3->bindParam(':mdp3', $mdp3);
$stmt3->execute();



$stmt4=$pdo->prepare("INSERT INTO annonce_p (id_u, nom, type, date_post, image1, image2, image3, description, prix, c_postal) VALUES ('2', 'Voiture peugeot 206+', 'vehicule', DATE(), 'images/peugeot-206-25.jpg', NULL, NULL, 'voiture à vendre, me contacter par mail pour plus de renseignement.', '1500', '42100');");
$stmt4->execute();
$stmt4->closeCursor();

$stmt5=$pdo->prepare("INSERT INTO annonce_p (id_u, nom, type, date_post, image1, image2, image3, description, prix, c_postal) VALUES ('2', 'Collection manga demon slayer', 'multimedia', DATE(), 'images/demon-slayer-kimetsu-no-yaiba-wallpaper-04.jpg', NULL, NULL, 'collection de manga que je ne lis plus', '340', '42000');");
$stmt5->execute();

header("Location:home.php");