CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    product_name VARCHAR(255) 
);

DELIMITER //

CREATE TRIGGER after_product_insert
AFTER INSERT ON produits
FOR EACH ROW
BEGIN
    UPDATE categories
    SET product_name = NEW.name
    WHERE id = NEW.category_id;
END //

DELIMITER ;



CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    image_url VARCHAR(255) NOT NULL, -- Ajout de la colonne pour l'URL de l'image
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


INSERT INTO categories (name) VALUES 
('Sandales Traditionnelles'), 
('Bottes en Cuir'), 
('Chaussures de Mariage'), 
('Ballerines Africaines'), 
('Chaussures en Tissu Wax'), 
('Espadrilles Africaines'), 
('Mocassins Traditionnels'), 
('Chaussures de Travail en Cuir'), 
('Sandales en Perles'), 
('Babouches Africaines'), 
('Chaussures pour Enfants'), 
('Chaussures de Sport');



CREATE TABLE commande_produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT,
    produit_id INT,
    quantity INT,
    FOREIGN KEY (id_commande) REFERENCES commandes(id_commande),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);








CREATE TABLE commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_superUser INT,
    total_price DECIMAL(10, 2) NOT NULL,
    date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en attente', 'validée') DEFAULT 'en attente',
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_superUser) REFERENCES superuser(id_superUser)
);


CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    telephone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);


CREATE TABLE superuser (
    id_superUser INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE clients (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    adresse TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    sexe VARCHAR(10) NOT NULL,
    statut ENUM('actif', 'inactif') DEFAULT 'actif'
);