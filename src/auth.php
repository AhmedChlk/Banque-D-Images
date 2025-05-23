<?php
session_start();

function registerUser(PDO $pdo, $login, $password, $nom, $prenom, $email, $confirm) {
    // Vérification des champs obligatoires
    if (empty($login) || empty($password) || empty($nom) || empty($prenom) || empty($email)) {
        return "Veuillez remplir tous les champs obligatoires.";
    }

    // Vérification email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Adresse email invalide.";
    }

    // Vérification longueurs minimales
    if (strlen($login) < 4) {
        return "Le login doit contenir au moins 4 caractères.";
    }
    if (strlen($password) < 6) {
        return "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm) {
        return "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si le login existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        return "Ce login est déjà utilisé.";
    }

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return "Cet email est déjà utilisé.";
    }

    // Hasher le mot de passe
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (login, password, nom, prenom, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$login, $hashed, $nom, $prenom, $email]);

    // Connecter l'utilisateur
    $_SESSION['user_id'] = $pdo->lastInsertId();
    return true;
}

function loginUser(PDO $pdo, $login, $password) {
    if (empty($login) || empty($password)) {
        return "Veuillez renseigner le login et le mot de passe.";
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if (!$user) {
        return "Aucun compte trouvé avec ce login.";
    }

    if (!password_verify($password, $user['password'])) {
        return "Mot de passe incorrect.";
    }

    $_SESSION['user_id'] = $user['id'];
    return true;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
