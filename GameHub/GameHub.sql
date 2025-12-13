CREATE DATABASE IF NOT EXISTS GameHub;

Use GameHub;

DROP TABLE IF EXISTS `joueurs`;
CREATE TABLE IF NOT EXISTS `joueurs` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(150) DEFAULT NULL,
  `Mail` varchar(200) NOT NULL,
  `Motdepasse` varchar(255) NOT NULL,
  `role` enum('joueur','admin','visiteur') NOT NULL DEFAULT 'joueur',
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
)

INSERT INTO `joueurs` (`ID`, `identifiant`, `Mail`, `Motdepasse`, `role`, `date_inscription`) VALUES
(1, 'VolZerr', 'volmyc.o.g@gmail.com', '$2y$10$STsEajyEjS/1Rpiv9anBg.6Lp68f.uJ1.Ow7tBGmdDAsb.VBx2QOm', 'joueur', '2025-10-01 12:08:30');

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(200) DEFAULT NULL,
  `Synopsis` varchar(255) DEFAULT NULL,
  `ImageUrl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
)        

INSERT INTO `jeux` (`ID`, `Nom`, `Synopsis`, `ImageUrl`) VALUES
(1, 'Nitro Racers Unleashed', 'jeu de course automobile intense et rapide, mettant en scène une voiture de sport ailée sur fond de paysage urbain au coucher du soleil, symbolisant la vitesse et la liberté', 'NRU.png'),
(2, 'Sky Dominators Ace Combat', 'Plongez dans des batailles aériennes palpitantes où des as du pilotage s affrontent dans les cieux pour dominer l espace aérien à travers des missions intenses et réalistes.', 'SDAC.png'),
(3, 'Football Legends Ace Stiker', 'Vivez l excitation du beau jeu en prenant le contrôle de votre équipe favorite, en exécutant des tactiques complexes et en marquant des buts spectaculaires pour remporter la victoire', 'FLAS.png'),
(4, 'Fighting Fury Clash Of Champions', 'Maîtrisez un combattant unique doté de mouvements et de combos dévastateurs, et défiez des adversaires dans des duels épiques où seule la force et la stratégie décident du vainqueur.', 'FFcc.png');


DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `joueur_id` int DEFAULT NULL,
  `jeu_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `joueur_id` (`joueur_id`),
  KEY `jeu_id` (`jeu_id`)
)

INSERT INTO jeux (Nom, Synopsis, ImageUrl) VALUES
('Nitro Racers Unleashed', 'jeu de course automobile intense et rapide, 
              mettant en scène une voiture de sport ailée sur fond de paysage urbain au coucher du soleil, 
              symbolisant la vitesse et la liberté', 'NRU.png'),
('Sky Dominators Ace Combat', 'Plongez dans des batailles aériennes palpitantes où des as du pilotage s affrontent 
              dans les cieux pour dominer l espace aérien à travers des missions intenses et réalistes.', 'SDAC.png'), 
('Football Legends Ace Stiker', 'Vivez l excitation du beau jeu en prenant le contrôle de votre équipe favorite, 
              en exécutant des tactiques complexes et en marquant des buts spectaculaires pour remporter la victoire', 'FLAS.png'),
('Fighting Fury Clash Of Champions', 'Maîtrisez un combattant unique doté de mouvements et de combos dévastateurs, 
              et défiez des adversaires dans des duels épiques où seule la force et la stratégie décident du vainqueur.', 'FFcc.png'); 


