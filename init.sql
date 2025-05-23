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
