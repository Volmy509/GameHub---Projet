CREATE DATABASE IF NOT EXISTS GameHub;

Use GameHub;

CREATE TABLE joueurs (
    ID int AUTO_INCREMENT primary key not null,
    identifiant VARCHAR(150),
    Mail VARCHAR(200) NOT NULL,
    Motdepasse VARCHAR(255) NOT NULL,
    role ENUM('joueur', 'admin', 'visiteur') NOT NULL DEFAULT 'joueur',
   date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
);

CREATE TABLE jeux (
    ID int AUTO_INCREMENT primary key not null,
    Nom VARCHAR(200),
    Synopsis VARCHAR (255),
    ImageUrl VARCHAR(255) NULL
)        

