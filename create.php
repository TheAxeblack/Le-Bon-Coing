<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");

include_once('includes/connex.inc.php');

$pdo = connexion('bdd.db');



$pdo->exec("DROP TABLE user");

$us = "CREATE TABLE IF NOT EXISTS user(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nom VARCHAR(255),
  mdp INTEGER,
  statut INT DEFAULT 0
)";


$pdo->exec($us);


$pdo->exec("DROP TABLE annonce_p");

$ann = "CREATE TABLE IF NOT EXISTS annonce_p(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nom VARCHAR(255),
  type VARCHAR(255),
  date_post DATE,
  image1 VARCHAR(255) NOT NULL,
  image2 VARCHAR(255),
  image3 VARCHAR(255),
  description VARCHAR(5000),
  prix INT,
  c_postal INT
)";

$pdo->exec($ann);

