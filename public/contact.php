<?php
require_once __DIR__ . '/../src/contact.php';
include "templates/header.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$success = $_SESSION['contact_success'] ?? null;
$error = $_SESSION['contact_error'] ?? null;
unset($_SESSION['contact_success'], $_SESSION['contact_error']);
?>

<div class="page-wrapper">
  <main class="main-content">
    <div class="auth-zone full">
      <h2>Contact</h2>
      <p class="contact-p">Une question, un retour ou un problème ? Remplissez le formulaire ci-dessous :</p>

      <?php if ($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 10px;">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 10px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="../src/contact.php" class="form">
        <input type="text" name="nom" placeholder="Votre nom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <textarea name="message" placeholder="Votre message" required rows="5" class="textarea-message"></textarea>
        <button type="submit" class="btn-primary full">Envoyer</button>
      </form>
    </div>
  </main>
</div>

<?php include "templates/footer.php"; ?>
