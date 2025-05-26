<?php

session_start();
require_once __DIR__ . '/../src/database.php';
$pdo = getDatabaseConnection();

$image_id = isset($_GET['image_id']) ? (int)$_GET['image_id'] : 0;
if ($image_id <= 0) {
    die("Image non spécifiée.");
}

$commentError = '';
$commentSuccess = '';

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    if (!$user_id) {
        $commentError = "Vous devez être connecté pour commenter.";
    } else {
        $comment_text = trim($_POST['comment']);
        if (empty($comment_text)) {
            $commentError = "Le commentaire ne peut pas être vide.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO comments (image_id, user_id, comment_text, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$image_id, $user_id, $comment_text]);
            

            header("Location: view-larger.php?image_id=" . $image_id);
            exit;
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$image_id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$image) {
    die("Image introuvable.");
}

$stmt = $pdo->prepare("
    SELECT c.*, COALESCE(u.prenom, 'Anonyme') AS display_name
    FROM comments c
    LEFT JOIN users u ON c.user_id = u.id
    WHERE c.image_id = ?
    ORDER BY c.created_at DESC
");
$stmt->execute([$image_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "templates/header.php";
?>

<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <main class="main-content larger-image-container">
        <div class="image-card larger-image">
            <div class="image-preview larger-image">
                <img src="<?= htmlspecialchars($image['path']) ?>" alt="<?= htmlspecialchars($image['caption'] ?? 'Image') ?>">
            </div>
        </div>

        <div class="comments-section">
            <h3>Commentaires</h3>

            <?php if ($commentError): ?>
                <div class="error-block"><?= htmlspecialchars($commentError) ?></div>
            <?php elseif ($commentSuccess): ?>
                <div class="success-block"><?= htmlspecialchars($commentSuccess) ?></div>
            <?php endif; ?>

            <?php if (empty($comments)): ?>
                <p>Aucun commentaire pour cette image.</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="avatar" style="background-image: url('assets/img/default-avatar.png');"></div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author"><?= htmlspecialchars($comment['display_name']) ?></span>
                                <span class="comment-date"><?= date('d M Y, H\hi', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <div class="comment-text"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($user_id): ?>
            <div class="comment-form-container">
                <h3>Ajouter un commentaire</h3>
                <form class="comment-form" method="POST" action="view-larger.php?image_id=<?= $image_id ?>">
                    <textarea name="comment" placeholder="Ajouter un commentaire..." required></textarea>
                    <button type="submit" class="btn-primary">Envoyer</button>
                </form>
            </div>
        <?php else: ?>
            <p>Vous devez <a href="auth-page.php">vous connecter</a> pour ajouter un commentaire.</p>
        <?php endif; ?>
    </main>
</div>

<script src="assets/js/sidebar-menu-handler.js"></script>
<?php include "templates/footer.php"; ?>
