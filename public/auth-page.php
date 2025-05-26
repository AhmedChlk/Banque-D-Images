<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/database.php';
require_once __DIR__ . '/../src/auth.php';

$pdo = getDatabaseConnection();

if (isset($_SESSION['user_id'])) {
    header("Location: gallery.php");
    exit;
}

$loginErrors = [];
$registerErrors = [];
$formType = 'login'; // par défaut

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $result = loginUser($pdo, $login, $password);
        if ($result === true) {
            $_SESSION['success_message'] = "Connexion réussie ! Bienvenue 👋";
            header("Location: gallery.php");
            exit;
        }
       else {
            $loginErrors[] = $result;
            $formType = 'login';
        }
    }

    if ($action === 'register') {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $result = registerUser($pdo, $login, $password, $nom, $prenom, $email, $confirm);
        if ($result === true) {
            $_SESSION['success_message'] = "Inscription réussie ! Vous êtes maintenant connecté.";
            header("Location: gallery.php");
            exit;
        } else {
            $registerErrors[] = $result;
            $formType = 'register';
        }
    }
}
?>

<?php include 'templates/header.php'; ?>
<link rel="stylesheet" href="assets/css/auth.css">
<div class="page-wrapper">
  <main class="main-content">
    <div class="auth-container">

      <!-- Bloc illustration + slogan -->
      <div class="slogan-zone">
        <div class="slogan-illustration-wrapper">
          <img src="assets/img/auth-illustration.svg" alt="Illustration banque d'images" class="auth-illustration">
        </div>
        <div class="slogan-text">
          <h1>Partagez vos plus belles images</h1>
          <p>Stockez, organisez et partagez vos créations en quelques clics.</p>
          <div class="auth-stats">
            <div><strong>12 000+</strong><br>images partagées</div>
            <div><strong>850+</strong><br>utilisateurs actifs</div>
            <div><strong>100%</strong><br>gratuit & sécurisé</div>
          </div>
        </div>
      </div>

      <!-- Zone de connexion/inscription -->
      <div class="auth-zone">
        <div class="tabs">
          <div class="tab <?= $formType === 'login' ? 'active' : '' ?>" data-tab="login">Connexion</div>
          <div class="tab <?= $formType === 'register' ? 'active' : '' ?>" data-tab="register">Inscription</div>
        </div>

        <!-- Form Connexion -->
        <form class="form <?= $formType === 'login' ? '' : 'hidden' ?>" id="form-login" method="POST">
          <input type="hidden" name="action" value="login">
          <input type="text" placeholder="Login" name="login" required>
          <input type="password" placeholder="Mot de passe" name="password" required>

          <?php if (!empty($loginErrors)): ?>
            <div class="error-block">
              <?php foreach ($loginErrors as $e): ?>
                <div>⚠️ <?= htmlspecialchars($e) ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <button class="btn-primary full" type="submit">Se connecter</button>
        </form>

        <!-- Form Inscription -->
        <form class="form <?= $formType === 'register' ? '' : 'hidden' ?>" id="form-register" method="POST">
          <input type="hidden" name="action" value="register">
          <input type="text" placeholder="Nom" name="nom" required>
          <input type="text" placeholder="Prénom" name="prenom" required>
          <input type="email" placeholder="Adresse email" name="email" required>
          <input type="text" placeholder="Login" name="login" required>
          <input type="password" placeholder="Mot de passe" name="password" required>
          <input type="password" placeholder="Confirmer le mot de passe" name="confirm_password" required>

          <?php if (!empty($registerErrors)): ?>
            <div class="error-block">
              <?php foreach ($registerErrors as $e): ?>
                <div>⚠️ <?= htmlspecialchars($e) ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <button class="btn-primary full" type="submit">S'inscrire</button>
        </form>
      </div>
    </div>
  </main>
</div>
<?php include 'templates/footer.php'; ?>

<script>
  const initialTab = '<?= $formType ?>';
</script>
<script src="assets/js/form-handler.js"></script>
