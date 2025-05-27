<?php
// public/add-contact.php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth-page.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['identifiant'])) {
    require_once __DIR__ . '/../src/database.php';
    $pdo = getDatabaseConnection();

    $login = trim($_POST['identifiant']);
    $currentUser = (int)$_SESSION['user_id'];

    // Vérifier que l'utilisateur existe et n'est pas soi-même
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ? AND id != ?");
    $stmt->execute([$login, $currentUser]);
    $row = $stmt->fetch();

    if ($row) {
        $contactId = (int)$row['id'];

        // Vérifie si le contact n'existe pas déjà
        $stmt2 = $pdo->prepare("SELECT 1 FROM contacts WHERE user_id = ? AND contact_user_id = ?");
        $stmt2->execute([$currentUser, $contactId]);
        if ($stmt2->fetch()) {
            $_SESSION['success_message'] = "Ce contact est déjà dans votre liste.";
        } else {
            // Ajout du contact
            $stmt3 = $pdo->prepare("INSERT INTO contacts (user_id, contact_user_id) VALUES (?, ?)");
            $stmt3->execute([$currentUser, $contactId]);
            $_SESSION['success_message'] = "Contact ajouté avec succès !";
        }
    } else {
        $_SESSION['success_message'] = "Utilisateur introuvable ou impossible d'ajouter soi-même.";
    }
}

header("Location: gallery.php");
exit;
