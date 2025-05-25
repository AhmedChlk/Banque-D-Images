<?php
session_start();
require_once __DIR__ . '/../src/database.php';
$pdo = getDatabaseConnection();

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

$images = [];
if ($searchQuery !== '') {
    $stmt = $pdo->prepare("SELECT * FROM images WHERE caption LIKE ? ORDER BY created_at DESC LIMIT 50");
    $stmt->execute(['%' . $searchQuery . '%']);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'templates/header.php';
?>

<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <main class="main-content">
        <div class="search-wrapper">
            <form action="search.php" method="get" class="search-bar">
                <input 
                    type="text" 
                    name="q" 
                    value="<?= htmlspecialchars($searchQuery) ?>" 
                    placeholder="Entrez des mots-clés..." 
                    class="search-input" 
                />
                <button type="submit" class="btn-primary btn-view">Rechercher</button>
            </form>
        </div>

        <div class="gallery-grid">
            <?php if (empty($images)): ?>
                <p>Aucune image trouvée pour : <strong><?= htmlspecialchars($searchQuery) ?></strong></p>
            <?php else: ?>
                <?php foreach ($images as $image): ?>
                    <div class="image-card">
                        <div class="image-preview">
                            <img src="<?= htmlspecialchars($image['path']) ?>" alt="<?= htmlspecialchars($image['caption'] ?? 'Image') ?>">
                        </div>
                        <div class="image-details">
                            <p class="image-caption">“<?= htmlspecialchars($image['caption']) ?>”</p>
                            <a href="view-larger.php?image_id=<?= (int)$image['id'] ?>" class="btn-view">Voir en grand</a>
                            <a href="gallery.php?user_id=<?= (int)$image['user_id'] ?>" class="gallery-link">Galerie du propriétaire</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include 'templates/footer.php'; ?>
