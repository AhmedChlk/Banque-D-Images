<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: auth-page.php");
    exit;
}

require_once '../src/database.php';
$pdo = getDatabaseConnection();

$stmt = $pdo->prepare("
    SELECT images.*, users.login 
    FROM images 
    JOIN users ON images.user_id = users.id 
    WHERE users.id = ? 
    ORDER BY images.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <main class="gallery-content">
        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (empty($images)): ?>
            <p>Aucune image à afficher pour le moment.</p>
        <?php else: ?>
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
        <?php endif; ?>
    </main>
</div>
<script src="assets/js/sidebar-menu-handler.js"></script>

<?php include 'templates/footer.php'; ?>
