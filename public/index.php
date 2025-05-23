<?php
session_start();

// Rediriger l'utilisateur connecté vers la galerie
if (isset($_SESSION['user_id'])) {
    header('Location: gallery.php');
    exit;
}

// Sinon, afficher la page d'authentification
require 'auth-page.php';
