<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: gallery.php');
    exit;
}

header("Location: auth-page.php");
exit;
