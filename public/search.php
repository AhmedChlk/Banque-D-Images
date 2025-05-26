<?php include 'templates/header.php'; ?>

<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <main class="main-content search-page">
        <form action="search.php" method="get" class="search-bar">
            <input type="text" name="q" placeholder="Entrez des mots-clés..." class="search-input"/>
            <button type="submit" class="search-btn">Rechercher</button>
        </form>

        <div class="image-result">
            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>

            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>

            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>

            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>

            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>

            <div class="image-card">
                <div class="image-preview"></div>
                <p class="image-caption">“Chatons mignons”</p>
                <a href="View-larger.php?id=123" class="btn-primary btn-view">Voir en grand</a><br />
                <a href="#" class="gallery-link">Galerie du propriétaire</a>
            </div>
        </div>
    </main>
</div>

<?php include 'templates/footer.php'; ?>
