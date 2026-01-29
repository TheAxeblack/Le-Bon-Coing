<?php
function connexion($base)
{
    try {
        $pdo = new PDO('sqlite:'.$base);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Problème à la connexion';
        die();
    }

    return $pdo;
}

?>