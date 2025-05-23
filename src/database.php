<?php

$DB_HOST = 'localhost';
$DB_NAME = 'l2info';
$DB_USER = 'l2info';
$DB_PASS = 'l2info';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8",
        $DB_USER,
        $DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.". $e->getMessage());
}
