<?php include "templates/header.php"; ?>

<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <main class="main-content">
    <div class="image-card larger-image">
        <div class="image-preview larger-image">

        </div>
    </div>

    <div class="comments-section">
        <h3>Commentaires</h3>
        <div class="comment-item">
            <div class="avatar" style="background-image: url('path_to_photo_bastien.jpg');"></div>
            <div class="comment-content">
                <div class="comment-header">
                <span class="comment-author">Bastien</span>
                <span class="comment-date">13 mai 2025, 22h20</span>
                </div>
                <div class="comment-text">Magnifique !</div>
            </div>
        </div>

        <div class="comment-item">
            <div class="avatar" style="background-image: url('path_to_photo_bastien.jpg');"></div>
            <div class="comment-content">
                <div class="comment-header">
                <span class="comment-author">Vous</span>
                <span class="comment-date">13 mai 2025, 22h22</span>
                </div>
                <div class="comment-text">Merci !</div>
            </div>
        </div>
    </div>
    <div>
        <h3>Ajouter un commentaire</h3>
        <form class="comment-form" method="POST" action="">
            <textarea name="comment" placeholder="Ajouter un commentaire..." required></textarea>
            <button type="submit" class="btn-primary">Envoyer</button>
        </form>
    </div>    
    </main>
</div>

<?php include "templates/footer.php" ?>