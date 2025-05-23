<?php
session_start();
session_unset(); 
session_destroy();

// Redirige vers la page de login
header("Location: auth-page.php");
exit;
