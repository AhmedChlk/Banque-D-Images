-- ===========================
-- RAZ de la base (DROP ALL)
-- ===========================
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS users;

-- ===========================
-- USERS
-- ===========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Quelques utilisateurs test
INSERT INTO users (login, password, nom, prenom, email) VALUES
('ahmed2004', '$2y$10$lsmIHX.7qsxPfn.7gYmf5eY4PaBBazK4JiAx9uy0sndIwQTPuDz0G', 'CHOULAK', 'Ahmed', 'ahmedchoulak2004@gmail.com'),
('bastien',   '$2y$10$lsmIHX.7qsxPfn.7gYmf5eY4PaBBazK4JiAx9uy0sndIwQTPuDz0G', 'Dupont', 'Bastien', 'bastien@example.com'),
('lisa',      '$2y$10$lsmIHX.7qsxPfn.7gYmf5eY4PaBBazK4JiAx9uy0sndIwQTPuDz0G', 'Marty', 'Lisa', 'lisa@example.com'),
('john',      '$2y$10$lsmIHX.7qsxPfn.7gYmf5eY4PaBBazK4JiAx9uy0sndIwQTPuDz0G', 'Smith', 'John', 'john@example.com');

-- ===========================
-- IMAGES
-- ===========================
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    path VARCHAR(255) NOT NULL,
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Liens images/owners avec légende
INSERT INTO images (user_id, path, caption) VALUES
-- Ahmed (id = 1)
(1, 'uploads/chat1.jpg', 'Chat mignon et curieux'),
(1, 'uploads/chat2.jpg', 'Chat qui dort paisiblement'),
(1, 'uploads/cheval.jpg', 'Cheval au galop'),
-- Bastien (id = 2)
(2, 'uploads/chien.jpg', 'Chien joueur'),
(2, 'uploads/loup.jpg', 'Loup en pleine forêt'),
-- Lisa (id = 3)
(3, 'uploads/grizzly.jpg', 'Grizzly qui pêche'),
(3, 'uploads/guepard.jpg', 'Guépard en pleine course'),
-- John (id = 4)
(4, 'uploads/lion.jpg', 'Lion majestueux'),
(4, 'uploads/requin.jpg', 'Requin dans l’océan');

-- ===========================
-- CONTACTS
-- ===========================
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    contact_user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Les contacts d'Ahmed
INSERT INTO contacts (user_id, contact_user_id) VALUES
(1, 2), -- Ahmed ajoute Bastien
(1, 3), -- Ahmed ajoute Lisa
(2, 1), -- Bastien ajoute Ahmed
(3, 4); -- Lisa ajoute John

-- ===========================
-- COMMENTS
-- ===========================
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    author VARCHAR(100) NOT NULL DEFAULT 'Anonyme',
    comment_text TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX (image_id)
);

-- Quelques commentaires de test
INSERT INTO comments (image_id, author, comment_text, created_at) VALUES
(1, 'Bastien', 'Magnifique ce chat !', '2025-05-13 22:20:00'),
(1, 'Lisa',    'Trop choupi', '2025-05-14 10:15:30'),
(2, 'Ahmed',   'Merci beaucoup !', '2025-05-14 12:00:00'),
(3, 'John',    'Wow, très beau cheval', '2025-05-14 15:22:00'),
(4, 'Lisa',    'Adorable chien !', '2025-05-15 11:11:11'),
(5, 'Ahmed',   'Superbe photo de loup', '2025-05-15 12:12:12');

