<?php
session_start();
require_once __DIR__ . '/../src/database.php';
$pdo = getDatabaseConnection();

$image_id = isset($_GET['image_id']) ? (int)$_GET['image_id'] : 0;
if ($image_id <= 0) {
    die("Image non spécifiée.");
}

$user_id = $_SESSION['user_id'] ?? null;
$commentError = '';

// Commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment_text = trim($_POST['comment']);
    if (empty($comment_text)) {
        $commentError = "Le commentaire ne peut pas être vide.";
    } else {
        $author = $_SESSION['user_login'] ?? 'Anonyme';
        $stmt = $pdo->prepare("INSERT INTO comments (image_id, author, comment_text, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$image_id, $author, $comment_text]);
        header("Location: view-larger.php?image_id=" . $image_id);
        exit;
    }
}

// Récupération de l'image
$stmt = $pdo->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$image_id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$image) {
    die("Image introuvable.");
}

// Récupération des commentaires
$stmt = $pdo->prepare("SELECT author AS display_name, comment_text, created_at FROM comments WHERE image_id = ? ORDER BY created_at DESC");
$stmt->execute([$image_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "templates/header.php";
?>

<div class="page-wrapper">
    <?php include "templates/sidebar.php"; ?>

    <main class="main-content main-view-larger">
        <div class="larger-image-wrapper">
            <a href="gallery.php" class="gallery-link">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la galerie</span>
            </a>
            <div class="image-larger">
                <img src="<?= htmlspecialchars($image['path']) ?>"
                     alt="<?= htmlspecialchars($image['caption'] ?? 'Image') ?>">
            </div>
            <p class="image-caption"><?= htmlspecialchars($image['caption']) ?></p>
            <p class="image-date">Posté le <?= date("d/m/Y à H:i", strtotime($image['created_at'])) ?></p>
        </div>

        <div class="comments-section">
            <h3>Commentaires</h3>

            <?php if ($commentError): ?>
                <div class="error-block"><?= htmlspecialchars($commentError) ?></div>
            <?php endif; ?>

            <?php if (empty($comments)): ?>
                <p>Aucun commentaire pour cette image.</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="avatar"></div>
                        <div class="comment-bubble">
                            <div class="comment-header">
                                <span class="comment-author"><?= htmlspecialchars($comment['display_name']) ?></span>
                                <span class="comment-date"><?= date('d M Y, H\hi', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <div class="comment-text"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

            <div class="comment-add-section">
                <?php if ($user_id): ?>
                    <form class="comment-form" method="POST" action="view-larger.php?image_id=<?= $image_id ?>">
                        <textarea name="comment" placeholder="Ajouter un commentaire..." required></textarea>
                        <button type="submit" class="btn-primary">Envoyer</button>
                    </form>
                <?php else: ?>
                    <p class="popup-login-message">Vous devez <a href="auth-page.php">vous connecter</a> pour commenter.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script src="assets/js/sidebar-menu-handler.js"></script>
<?php include "templates/footer.php"; ?>
