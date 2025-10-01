<!-- NavBar border radius, shadow box, profil a gauche, rechercher un jeu au centre, se deconnecter/se conecter a droit etoiles avec les favoris -->
  <?php session_start(); 

//Connexion a la base de données 
  $host = 'localhost';
  $dbname = 'GameHub';
  $user = 'root'; // A modifier pour déploiement
  $pass = ''; // A modifier pour déploiement

  $role = $_SESSION['role'];

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
  ?>

  <!DOCTYPE html>
  <html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🕹️ GameHub </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <style>
    body {
      background: linear-gradient(135deg, #000a97ff 0%, #b918c8ff 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    /* Navbar avec effet glassmorphism */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 1rem 2rem;
        }

        .nav-container {
            max-width: 1250px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between; 
            align-items: center; 
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .logo img {
            width: 40px;
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 0.6rem 1.2rem;
            color: white;
            outline: none;
            width: 200px;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            width: 250px;
            background: rgba(255, 255, 255, 0.25);
        }

        .btn-connect {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-connect:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

    .gallery-container {
      position: relative;
      width: 250px;
      height: 350px;
      transform-style: preserve-3d;
      animation: spin 20s linear infinite;
    }

    .gallery-container span {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      transform-origin: center;
      transform-style: preserve-3d;
      transition: transform 0.5s, z-index 0.5s;
    }

    .gallery-container img {
      width: 100%;
      height: 100%;
      margin-top: 30px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      transition: transform 0.5s;
      cursor: pointer;
    }

    /* Animation de rotation */
    @keyframes spin {
      0% { transform: perspective(1000px) rotateY(0deg); }
      100% { transform: perspective(1000px) rotateY(360deg); }
    }

    /* Hover : mettre l'image au premier plan */
    .gallery-container span:hover {
      transform: scale(1.3) translateZ(150px);
      z-index: 100;
    }

    .gallery-container span:hover img {
      transform: scale(1.1);
    }

  </style>
  </head>

<body>
  <!-- PAGE POUR LES JOUEURS -->
 <?php if ($role === 'joueur'): ?>
<nav>
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span>GAME HUB</span>
            </a>
              
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher un jeu">
            </div>

            <a href="login.php"><button class="btn-connect">Se déconnecter</button></a>
            <a href="favorite.php"><button class="btn-connect">Mes Favoris</button></a>
            <!-- <a href="register.php"><button class="btn-connect">S'inscrire</button></a> -->
        </div>
    </nav>
</div>

 <div class="gallery-container">
    <span style="--i:1; transform: rotateY(calc(360deg / 8 * 1)) translateZ(350px);">
      <img src="1.jpg" alt="">
    </span>
    <span style="--i:2; transform: rotateY(calc(360deg / 8 * 2)) translateZ(350px);">
      <img src="2.jpg" alt="">
    </span>
    <span style="--i:3; transform: rotateY(calc(360deg / 8 * 3)) translateZ(350px);">
      <img src="3.jpg" alt="">
    </span>
    <span style="--i:4; transform: rotateY(calc(360deg / 8 * 4)) translateZ(350px);">
      <img src="4.jpg" alt="">
    </span>
    <span style="--i:5; transform: rotateY(calc(360deg / 8 * 5)) translateZ(350px);">
      <img src="5.jpg" alt="">
    </span>
    <span style="--i:6; transform: rotateY(calc(360deg / 8 * 6)) translateZ(350px);">
      <img src="6.jpg" alt="">
    </span>
    <span style="--i:7; transform: rotateY(calc(360deg / 8 * 7)) translateZ(350px);">
      <img src="7.jpg" alt="">
    </span>
    <span style="--i:8; transform: rotateY(calc(360deg / 8 * 8)) translateZ(350px);">
      <img src="8.jpg" alt="">
    </span>
  </div> 
<?php endif; ?>

<!-- PAGE POUR LES Visiteur -->
 <?php if ($role === ''): ?>
  <body>
<nav>
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span>GAME HUB</span>
            </a>
              
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher un jeu">
            </div>

            <a href="login.php"><button class="btn-connect">Se connecter</button></a>
            <a href="register.php"><button class="btn-connect">S'inscrire</button></a>
        </div>
    </nav>
</div>

 <div class="gallery-container">
    <span style="--i:1; transform: rotateY(calc(360deg / 8 * 1)) translateZ(350px);">
      <img src="1.jpg" alt="">
    </span>
    <span style="--i:2; transform: rotateY(calc(360deg / 8 * 2)) translateZ(350px);">
      <img src="2.jpg" alt="">
    </span>
    <span style="--i:3; transform: rotateY(calc(360deg / 8 * 3)) translateZ(350px);">
      <img src="3.jpg" alt="">
    </span>
    <span style="--i:4; transform: rotateY(calc(360deg / 8 * 4)) translateZ(350px);">
      <img src="4.jpg" alt="">
    </span>
    <span style="--i:5; transform: rotateY(calc(360deg / 8 * 5)) translateZ(350px);">
      <img src="5.jpg" alt="">
    </span>
    <span style="--i:6; transform: rotateY(calc(360deg / 8 * 6)) translateZ(350px);">
      <img src="6.jpg" alt="">
    </span>
    <span style="--i:7; transform: rotateY(calc(360deg / 8 * 7)) translateZ(350px);">
      <img src="7.jpg" alt="">
    </span>
    <span style="--i:8; transform: rotateY(calc(360deg / 8 * 8)) translateZ(350px);">
      <img src="8.jpg" alt="">
    </span>
  </div> 
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
  </html>