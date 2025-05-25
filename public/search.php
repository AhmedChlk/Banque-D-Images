<?php include 'templates/header.php'; ?>

<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <main class="main-content">
        <div class="search-wrapper">
            <form action="search.php" method="get" class="search-bar">
                <input 
                    type="text" 
                    name="q" 
                    value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" 
                    placeholder="Entrez des mots-clés..." 
                    class="search-input" 
                />
                <button type="submit" class="btn-primary btn-view">Rechercher</button>
            </form>
        </div>

        <div class="gallery-grid">
            <!-- Résultats simulés (peuvent être remplacés par une boucle PHP dynamique plus tard) -->
            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chat1.jpg" alt="Chaton mignon">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chatons mignons”</p>
                    <a href="view-larger.php?id=123" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>

            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>

            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>

            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>

            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>


            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>


            <div class="image-card">
                <div class="image-preview">
                    <img src="uploads/chien1.jpg" alt="Chien joueur">
                </div>
                <div class="image-details">
                    <p class="image-caption">“Chien joueur”</p>
                    <a href="view-larger.php?id=124" class="btn-view">Voir en grand</a>
                    <a href="#" class="gallery-link">Galerie du propriétaire</a>
                </div>
            </div>

            <!-- Ajoute d'autres blocs image ici -->
        </div>
    </main>
</div>

<?php include 'templates/footer.php'; ?>
