-- Assurez-vous d'être connecté à la base de données 'l2info' avec l'utilisateur 'l2info'

-- Supprime la table si elle existe
DROP TABLE IF EXISTS users;

-- Création de la table 'users'
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Supprimer la table si elle existe
DROP TABLE IF EXISTS images;

-- Créer la table d'images
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    path VARCHAR(255) NOT NULL,
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Ajouter un utilisateur de test
INSERT INTO users (login, password, nom, prenom, email)
VALUES (
  'ahmed2004',
  '$2y$10$lsmIHX.7qsxPfn.7gYmf5eY4PaBBazK4JiAx9uy0sndIwQTPuDz0G',
  'CHOULAK',
  'Ahmed',
  'ahmedchoulak2004@gmail.com'
);

-- Ajouter des images test
INSERT INTO images (user_id, path, caption)
VALUES 
(1, 'uploads/chat1.jpg', 'Chat mignon'),
(1, 'uploads/chat2.jpg', 'Chat curieux');
