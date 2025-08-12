
-- Creation de la base de donnees
CREATE DATABASE IF NOT EXISTS if0_39629470_fasoluxehotelBD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE if0_39629470_fasoluxehotelBD;

-- Table des hotels
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    ville VARCHAR(255) NOT NULL,
    adresse TEXT NOT NULL,
    description TEXT,
    photo_url VARCHAR(255),
    categorie INT NOT NULL, -- ex: 3, 4, 5 etoiles
    email VARCHAR(255),
    site_web VARCHAR(255)
);

-- Table des types de chambres
CREATE TABLE types_chambre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL -- ex: Simple, Double, Suite
);

-- Table des chambres
CREATE TABLE chambres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    type_chambre_id INT NOT NULL,
    numero_chambre VARCHAR(20) NOT NULL,
    description TEXT,
    equipements TEXT, -- ex: "Wi-Fi, TV, Climatisation"
    tarif_nuit DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE,
    FOREIGN KEY (type_chambre_id) REFERENCES types_chambre(id)
);

-- Table des clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL, -- Longueur reduite pour l'index UNIQUE
    telephone VARCHAR(50),
    mot_de_passe VARCHAR(255) NOT NULL, -- Pour l'espace client
    classification ENUM('Occasionnel', 'Regulier', 'VIP') DEFAULT 'Occasionnel'
);

-- Table des reservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    chambre_id INT NOT NULL,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    nombre_personnes INT NOT NULL,
    numero_confirmation VARCHAR(100) UNIQUE NOT NULL,
    statut ENUM('Confirmee', 'Annulee', 'En cours', 'Terminee') DEFAULT 'Confirmee',
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (chambre_id) REFERENCES chambres(id)
);

-- Table des services de l'hotel
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    tarif DECIMAL(10, 2) DEFAULT 0.00, -- 0 pour les services gratuits
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

-- Table de liaison pour les services supplementaires d'une reservation
CREATE TABLE reservation_services (
    reservation_id INT NOT NULL,
    service_id INT NOT NULL,
    PRIMARY KEY (reservation_id, service_id),
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

-- Table des factures
CREATE TABLE factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    montant_ht DECIMAL(10, 2) NOT NULL,
    tva DECIMAL(10, 2) NOT NULL,
    montant_ttc DECIMAL(10, 2) NOT NULL,
    date_emission DATE NOT NULL,
    statut_paiement ENUM('En attente', 'Payee') DEFAULT 'En attente',
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);

-- Table des utilisateurs (personnel de l'hotel)
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL, -- Longueur reduite pour l'index UNIQUE
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('Reception', 'Admin') NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);

-- --- DONNEES D'EXEMPLE ---

-- Types de chambre
INSERT INTO types_chambre (nom) VALUES ('Simple'), ('Double'), ('Suite');

-- Hotels
INSERT INTO hotels (nom, ville, adresse, description, categorie, email, site_web) VALUES
('FasoLuxe Ouaga 2000', 'Ouagadougou', 'Avenue Pascal Zagre, Ouaga 2000', 'Un hotel de luxe au coeur du quartier des affaires.', 5, 'contact.ouaga@fasoluxe.com', 'www.fasoluxe-ouaga.com'),
('FasoLuxe Bobo Dioulasso', 'Bobo-Dioulasso', 'Place de la Nation', 'Charme et tradition au centre de la capitale economique.', 4, 'contact.bobo@fasoluxe.com', 'www.fasoluxe-bobo.com');

-- Chambres pour Ouaga 2000
INSERT INTO chambres (hotel_id, type_chambre_id, numero_chambre, equipements, tarif_nuit) VALUES
(1, 1, '101', 'Wi-Fi, TV, Climatisation', 65000),
(1, 2, '102', 'Wi-Fi, TV, Climatisation, Mini-bar', 85000),
(1, 3, '201', 'Wi-Fi, TV, Climatisation, Mini-bar, Vue sur jardin, Salon', 150000);

-- Chambres pour Bobo
INSERT INTO chambres (hotel_id, type_chambre_id, numero_chambre, equipements, tarif_nuit) VALUES
(2, 1, 'A1', 'Wi-Fi, TV', 45000),
(2, 2, 'A2', 'Wi-Fi, TV, Climatisation', 60000);

-- Services
INSERT INTO services (hotel_id, nom, tarif) VALUES
(1, 'Petit-dejeuner', 10000),
(1, 'Parking securise', 5000),
(1, 'Acces Piscine', 0),
(2, 'Petit-dejeuner', 8000),
(2, 'Guide touristique', 25000);

-- Utilisateurs
INSERT INTO utilisateurs (hotel_id, nom, email, mot_de_passe, role) VALUES
(NULL, 'Admin General', 'admin@fasoluxe.com', 'password', 'Admin'),
(1, 'Agent Reception Ouaga', 'reception.ouaga@fasoluxe.com', 'password', 'Reception'),
(2, 'Agent Reception Bobo', 'reception.bobo@fasoluxe.com', 'password', 'Reception');

ALTER TABLE clients ADD COLUMN carte_fidelite TINYINT(1) DEFAULT 0;
ALTER TABLE clients ADD COLUMN reduction DECIMAL(5,2) DEFAULT 0.00;
