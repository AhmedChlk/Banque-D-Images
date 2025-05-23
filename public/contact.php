<?php include "templates/header.php"; ?>

<div class="page-wrapper">
  <main class="main-content">
    <div class="auth-zone full">
      <h2>Contact</h2>
      <p class="contact-p">Une question, un retour ou un problème ? Remplissez le formulaire ci-dessous :</p>
      <form method="post" action="mailto:admin@example.com" class="form" enctype="text/plain">
        <input type="text" name="name" placeholder="Votre nom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <textarea name="message" placeholder="Votre message" required rows="5" class="textarea-message"></textarea>
        <button type="submit" class="btn-primary full">Envoyer</button>
      </form>
    </div>
  </main>
</div>

<?php include "templates/footer.php"; ?>
