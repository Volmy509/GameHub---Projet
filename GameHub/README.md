# GameHub

Description
-----------
GameHub est une petite application web de type catalogue/communauté centrée sur les jeux vidéo. Elle permet aux utilisateurs de créer un compte, de se connecter, d'explorer des fiches de jeux (titre, synopsis, image) et d'ajouter des jeux à leurs favoris.

But (objectifs)
----------------
- Proposer une interface simple pour découvrir et organiser des jeux.
- Permettre aux joueurs de sauvegarder leurs jeux préférés (favoris).
- Servir de prototype pour apprendre les bonnes pratiques PHP (sécurité, séparation logique/présentation).

Technologies utilisées
----------------------
- Serveur web : WAMP (Windows + Apache + MySQL + PHP)
- Base de données : MySQL 
- CSS : Bootstrap (CDN) + CSS personnalisé
- Fonts / icônes : Font Awesome (CDN)

Langages utilisés
-----------------
- PHP (back-end, interactions avec la BDD, sessions)
- SQL (structure et requêtes MySQL)
- HTML & CSS (structure et styles)
- JavaScript (pour petites interactions et animations via CDN)

Structure du projet (aperçu)
----------------------------
- `index.php` : page d'accueil / catalogue.
- `login.php` / `register.php` / `logout.php` : gestion d'authentification.
- `favorite.php` : ajout / affichage des favoris.
- `modifier.php` : page de modification du profil (en cours).
- `GameHub.sql` : script de création de la base de données et des tables.

Installation rapide
------------------
1. Placer le dossier `GameHub` dans le répertoire `www` de WAMP.
2. Importer `GameHub.sql` dans votre instance MySQL (phpMyAdmin ou CLI).
3. Lancer WAMP, ouvrir `http://localhost/GameHub-Projet/GameHub/index.php`.
4. Créer un compte via `register.php`, se connecter, tester l'ajout aux favoris.

Licence
-------
Projet personnel / pédagogique — ©Volmy.
