<?php include 'templates/header.php'; ?>
<div class="page-wrapper">
    <?php include 'templates/sidebar.php'; ?>

        <main class="gallery-content">
                <?php
                //juste pour tester
                for ($i = 0; $i < 8; $i++) {
                    echo '
                    <div class="image-card">
                    <div class="image-preview"> <img src="assets/img/logo.png" alt="Logo"></div>
                    <div class="image-date">“12 mai 2025”</div>
                    <button class="btn-view">Voir</button>
                    </div>';
                }
                ?>
                
            </div>
        </main>
</div>
<?php include 'templates/footer.php'; ?>

<script src="assets/js/form-handler.js"></script>
