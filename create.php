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

      

