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

// Par défaut, galerie de l'utilisateur connecté
$target_user_id = $_SESSION['user_id'];
$is_contact_gallery = false;

if (isset($_GET['user_id']) && ctype_digit($_GET['user_id'])) {
    $target_user_id = (int)$_GET['user_id'];
    $is_contact_gallery = ($target_user_id !== (int)$_SESSION['user_id']);
}

$stmt = $pdo->prepare("SELECT login FROM users WHERE id = ?");
$stmt->execute([$target_user_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);
$owner_login = $owner ? $owner['login'] : null;

if (!$owner_login) {
    die("Utilisateur introuvable.");
}

$stmt = $pdo->prepare("
    SELECT images.*, users.login 
    FROM images 
    JOIN users ON images.user_id = users.id 
    WHERE users.id = ? 
    ORDER BY images.created_at DESC
");
$stmt->execute([$target_user_id]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>

<?php include 'templates/header.php'; ?>
<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <?php if ($successMessage): ?>
    <div class="toast success-toast" id="success-toast">
        <?= htmlspecialchars($successMessage) ?>
    </div>
    <?php endif; ?>

    <main class="gallery-content">
        <?php if ($is_contact_gallery): ?>
            <h2 style="width: 100%;text-align:left;margin-bottom:14px;font-size:1.45rem;color:#185b9a;">
                Galerie de : <?= htmlspecialchars($owner_login) ?>
            </h2>
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
                    <p class="image-date">
                        Posté par <?= htmlspecialchars($image['login']) ?> le 
                        <?= date("d/m/Y à H:i", strtotime($image['created_at'])) ?>
                    </p>
                    <a href="view-larger.php?image_id=<?= $image['id'] ?>" class="btn-view">Voir en grand</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<script src="assets/js/sidebar-menu-handler.js"></script>
<script src="assets/js/toast-handler.js"></script>
<?php include 'templates/footer.php'; ?> 