<?php
//remarque il faut s'assurer d'avoir php-mysql sinon ca ne marche pas 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../src/database.php';  
echo "Connexion réussie à la base de données.";
