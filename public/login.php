<?php include 'templates/header.php'; ?>
<div class="page-wrapper">
  <main class="main-content">
    <div class="content">
      <div class="slogan-zone">
        <h1>Partagez vos plus belles images</h1>
        <p>Stockez, organisez et partagez vos créations en quelques clics.</p>
      </div>

      <div class="auth-zone">
        <div class="tabs">
          <div class="tab active" data-tab="login">Connexion</div>
          <div class="tab" data-tab="register">Inscription</div>
        </div>

        <!-- Formulaire Connexion -->
        <form class="form" id="form-login">
          <input type="text" placeholder="Login" name="login">
          <input type="password" placeholder="Mot de passe" name="password">
          <button class="btn-primary full" type="submit">Se connecter</button>
        </form>

        <!-- Formulaire Inscription -->
        <form class="form hidden" id="form-register">
          <input type="text" placeholder="Nom" name="nom">
          <input type="text" placeholder="Prénom" name="prenom">
          <input type="email" placeholder="Adresse email" name="email">
          <input type="password" placeholder="Mot de passe" name="password">
          <input type="password" placeholder="Confirmer le mot de passe" name="confirm_password">
          <button class="btn-primary full" type="submit">S'inscrire</button>
        </form>
      </div>
    </div>
  </main>
</div>
<?php include 'templates/footer.php'; ?>

<!-- Lien JS -->
<script src="assets/js/form-handler.js"></script>
