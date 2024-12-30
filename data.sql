CREATE DATABASE IF NOT EXISTS location;
USE location;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    archive ENUM('true', 'false') NOT NULL DEFAULT 'false'
);

CREATE TABLE cars (
    id_car INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('luxe', 'famille', 'SUV', 'sportive', 'Minivan') NOT NULL,
    modele VARCHAR(100) NOT NULL,
    prix INT NOT NULL,
    place VARCHAR(150) NOT NULL,
    disponibiliter BIT(1) NOT NULL DEFAULT 1,
    image VARCHAR(300)
);

CREATE TABLE role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    role ENUM('admin', 'user'),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_car INT,
    date_reservation DATE NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_car) REFERENCES cars(id_car) ON DELETE CASCADE
);

CREATE TABLE avis (
    id_avis INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_car INT,
    avis TEXT NOT NULL,
    archive_avis ENUM('true', 'false') NOT NULL DEFAULT 'false',
    FOREIGN KEY (id_client) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_car) REFERENCES cars(id_car) ON DELETE CASCADE
);
