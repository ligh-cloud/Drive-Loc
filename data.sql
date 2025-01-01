CREATE DATABASE IF NOT EXISTS location;
USE location;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    archive ENUM('true', 'false') NOT NULL DEFAULT 'false',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE cars (
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

CREATE TABLE role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE reservations (
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

CREATE TABLE avis (
    id_avis INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_car INT NOT NULL,
    note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT NOT NULL,
    archive_avis ENUM('true', 'false') NOT NULL DEFAULT 'false',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_car) REFERENCES cars(id_car)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);




-- CREATE INDEX idx_user_email ON users(email);
-- CREATE INDEX idx_car_category ON cars(category);
-- CREATE INDEX idx_reservation_dates ON reservations(date_debut, date_fin);