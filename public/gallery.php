<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth-page.php");
    exit;
}

require_once '../src/database.php';
$pdo = getDatabaseConnection();

// Récupération des images (de tous les utilisateurs ou seulement celui connecté)
$stmt = $pdo->prepare("SELECT images.*, users.login FROM images JOIN users ON images.user_id = users.id ORDER BY created_at DESC");
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <main class="gallery-content">
        <?php foreach ($images as $image): ?>
            <div class="image-card">
                <div class="image-preview">
                    <img src="<?= htmlspecialchars($image['path']) ?>" alt="image">
                </div>
                <p class="image-caption"><?= htmlspecialchars($image['caption']) ?></p>
                <p class="image-date">Posté par <?= htmlspecialchars($image['login']) ?> le <?= date("d/m/Y à H:i", strtotime($image['created_at'])) ?></p>
                <a href="view-larger.php" class="btn-view">Voir en grand</a>
            </div>
        <?php endforeach; ?>
    </main>
</div>
<script src="assets/js/sidebar-menu-handler.js"></script>

<?php include 'templates/footer.php'; ?>
