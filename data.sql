CREATE DATABASE IF NOT EXISTS location;
USE location;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    archive ENUM('true', 'false') NOT NULL DEFAULT 'false',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS cars (
    id_car INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(100) NOT NULL,
    modele VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    places INT NOT NULL,
    disponibilite BOOLEAN NOT NULL DEFAULT true,
    image VARCHAR(300),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_car INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('en_cours', 'terminee', 'annulee') NOT NULL DEFAULT 'en_cours',
    prix_total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_car) REFERENCES cars(id_car)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS avis (
    id_avis INT AUTO_INCREMENT PRIMARY KEY,
    id_reservation INT NOT NULL,
    note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT NOT NULL,
    archive_avis ENUM('true', 'false') NOT NULL DEFAULT 'false',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_reservation) REFERENCES reservations(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE theme (
    id_theme INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE article (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    statut ENUM('accepter' , 'en attente' , 'refuser') DEFAULT 'en attente',
    image VARCHAR(150),
    video VARCHAR(150),
    user_id INT,
    theme_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (theme_id) REFERENCES theme(id_theme)
);

CREATE TABLE commentaire (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    commentaire TEXT NOT NULL
);
CREATE TABLE commentaireArticle(
    id_commentaire INT,
    id_article INT,
    FOREIGN KEY (id_commentaire) REFERENCES commentaire(id_commentaire),
    FOREIGN KEY (id_article) REFERENCES article(id_article)
);

CREATE TABLE tags (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(150) NOT NULL
);

CREATE TABLE acrticleTags (
    id_article INT,
    id_tag INT,
    PRIMARY KEY (id_article, id_tag),
    FOREIGN KEY (id_article) REFERENCES article(id_article),
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
);
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (article_id) REFERENCES article(id_article)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
