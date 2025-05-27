<?php
session_start();
require_once __DIR__ . '/../src/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth-page.php");
    exit;
}

$pdo = getDatabaseConnection();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification fichier envoyé
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Erreur lors de l'envoi de l'image.";
    } else {
        $file = $_FILES['image'];
        $caption = trim($_POST['caption'] ?? '');

        // Validation de l'image (taille & type)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5 Mo max

        if (!in_array($file['type'], $allowedTypes)) {
            $error = "Seuls les formats JPG, PNG, GIF et WEBP sont autorisés.";
        } elseif ($file['size'] > $maxSize) {
            $error = "L'image ne doit pas dépasser 5 Mo.";
        } else {
            // Préparer le chemin de destination
            $uploadsDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }

            // Générer un nom de fichier unique
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileName = uniqid('img_', true) . '.' . $ext;
            $destPath = $uploadsDir . $fileName;
            $relativePath = 'uploads/' . $fileName; // pour l'URL publique

            // Déplacer le fichier uploadé
            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                // Sauvegarder l'info en base
                $stmt = $pdo->prepare("INSERT INTO images (user_id, path, caption, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$_SESSION['user_id'], $relativePath, $caption]);
                $_SESSION['success_message'] = "Image téléchargée avec succès !";
                header("Location: gallery.php");
                exit;
            } else {
                $error = "Erreur lors de l'enregistrement de l'image.";
            }
        }
    }
}

include "templates/header.php";
?>
<link rel="stylesheet" href="assets/css/pages/upload.css">
<div class="page-wrapper">
    <?php include "templates/sidebar.php"; ?>

    <main class="main-content">

        <div class="auth-zone full upload-card">
            <a href="gallery.php" class="gallery-link">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la galerie</span>
            </a>
            <h2>
                <i class="fa-solid fa-upload"></i> Upload une image
            </h2>

            <p class="upload-sous-titre">Choisissez une image à partager sur la plateforme.</p>

            <?php if ($error): ?>
                <div class="error-block"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form class="form upload-form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image"><i class="fa-regular fa-image"></i> Sélectionner une image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="caption"><i class="fa-regular fa-comment"></i> Légende (facultatif)</label>
                    <input type="text" id="caption" name="caption" maxlength="200" placeholder="Une légende pour l’image...">
                </div>
                <button type="submit" class="btn-primary full"><i class="fa-solid fa-cloud-arrow-up"></i> Envoyer</button>
            </form>


        </div>
    </main>
</div>
<script src="assets/js/sidebar-menu-handler.js"></script>
<?php include "templates/footer.php"; ?>
