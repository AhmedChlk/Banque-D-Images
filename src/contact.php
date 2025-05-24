<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($nom) || empty($email) || empty($message)) {
        $_SESSION['contact_error'] = "Tous les champs sont obligatoires.";
        header("Location: ../public/contact.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_error'] = "Adresse email invalide.";
        header("Location: ../public/contact.php");
        exit;
    }

    $to = "ahmechoulak2004@gmail.com";
    $subject = "Nouveau message de contact";
    $headers = "From: " . $email;
    $body = "Nom : $nom\nEmail : $email\nMessage :\n$message";

    // dans un cas normal mais nous on fera juste un log en local
    // mail($to, $subject, $body, $headers);

    // Écriture dans le fichier contact.log
    $logEntry = "=== Nouveau message de contact ===\n";
    $logEntry .= "Date : " . date('Y-m-d H:i:s') . "\n";
    $logEntry .= "Nom : $nom\n";
    $logEntry .= "Email : $email\n";
    $logEntry .= "Message :\n$message\n";
    $logEntry .= "===============================\n\n";

    file_put_contents(__DIR__ . "/../log/contact.log", $logEntry, FILE_APPEND);

    $_SESSION['contact_success'] = "Votre message a bien été envoyé. Merci !";
    header("Location: ../public/contact.php");
    exit;
}
?>
