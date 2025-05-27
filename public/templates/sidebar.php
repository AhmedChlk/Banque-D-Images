<aside class="sidebar">
  <div class="toolbar-row">
    <button class="toolbar-btn" id="menu-toggle">
      <i class="fa-solid fa-folder"></i> Menu ▼
    </button>
    <div id="menu-options" class="menu-options hidden">
      <a href="search.php" class="menu-link">
        <i class="fa-solid fa-magnifying-glass"></i> Rechercher
      </a>
      <a href="upload.php" class="menu-link">
        <i class="fa-solid fa-upload"></i> Upload
      </a>
      <a href="logout.php" class="menu-link logout">
        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
      </a>
    </div>
    <button class="toolbar-btn add-contact-btn" id="add-contact-btn">
      <i class="fa-solid fa-user-plus"></i> Ajouter un contact
    </button>
  </div>

  <div id="add-contact-form" class="add-contact-form hidden">
    <form method="POST" action="add-contact.php" class="form add-contact-form-inner">
      <input type="text" name="identifiant" class="add-contact-input" placeholder="Nom d'utilisateur" required>
      <button type="submit" class="btn-primary full"><i class="fa-solid fa-user-plus"></i> Ajouter</button>
    </form>
  </div>

  <div class="contacts-list">
    <h4>Mes contacts</h4>
    <ul class="contacts-ul">
      <?php
      if (session_status() === PHP_SESSION_NONE) session_start();
      require_once __DIR__ . '/../../src/database.php';
      require_once __DIR__ . '/../../src/contact_list.php';

      $contacts = [];
      if (isset($_SESSION['user_id'])) {
          $pdo = getDatabaseConnection();
          $contacts = getUserContacts($pdo, (int)$_SESSION['user_id']);
      }

      if (empty($contacts)) {
          echo "<li class='contact-li'>Aucun contact.</li>";
      } else {
          foreach ($contacts as $contact) {
              echo '<li class="contact-li">
                      <a href="gallery.php?user_id=' . (int)$contact['id'] . '" class="contact-link">
                        <i class="fa-solid fa-user"></i> ' . htmlspecialchars($contact['login']) . '
                      </a>
                    </li>';
          }
      }
      ?>
    </ul>
  </div>
</aside>
