<!-- NavBar border radius, shadow box, profil a gauche, rechercher un jeu au centre, se deconnecter/se conecter a droit etoiles avec les favoris -->
  <?php session_start(); 

//Connexion a la base de données 
  $host = 'localhost';
  $dbname = 'GameHub';
  $user = 'root'; // A modifier pour déploiement
  $pass = ''; // A modifier pour déploiement

  $role = $_SESSION['role'] ?? '';

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
  <link rel="stylesheet" href="style.css">
  <style>
  body {
  font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
  color: #fff;
  margin:0;
  padding: 80px;
  background: linear-gradient(135deg,#030426 0%, #0b0620 100%);
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

        .navbar nav, nav{
  background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
}

.container{max-width:1200px;margin:6.5rem auto 2rem;}
.page-title{margin:1rem 0 1.5rem;font-size:1.4rem;color:#fff;text-align:left}

/* Cards grid */
.cards-area{margin-top:2rem}
.cards-title{color:#fff;margin-bottom:1rem}
.cards{
  display:grid;
  grid-template-columns: repeat(auto-fill,minmax(240px,1fr));
  gap:1.1rem;
}
.card{
  background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.12));
  border-radius:12px;
  overflow:hidden;
  position:relative;
  min-height:260px;
  box-shadow: 0 8px 24px rgba(2,6,23,0.6);
  transition: transform .28s ease, box-shadow .28s ease;
  display:flex;
  flex-direction:column;
}
.card:hover{
  transform: translateY(-8px);
  box-shadow:0 18px 40px rgba(2,6,23,0.7)
}

.card-image{
  height:180px;
  width: 100%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #000;
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.card-desc{
  margin-top:auto; /* stick to bottom */
  padding:14px;
  background: linear-gradient(180deg, rgba(0,0,0,0.0), rgba(0,0,0,0.45));
  color:#fff;
  backdrop-filter: blur(6px);
}
.card-desc h3{
  margin:0 0 6px;
  font-size:1.05rem
}
.card-desc p{
  margin:0;
  font-size:0.9rem;
  opacity:0.95}

/* Responsive tweaks */
@media (max-width:520px){
  .card-image{height:130px}
  .cards{gap:.8rem}
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

            <a href="logout.php"><button class="btn-connect">Se déconnecter</button></a>
            <a href="favorite.php"><button class="btn-connect">Mes Favoris</button></a>
            <!-- <a href="register.php"><button class="btn-connect">S'inscrire</button></a> -->
        </div>
    </nav>
</div>

<?php endif; ?>

<!-- PAGE POUR LES Visiteur -->
<?php if (empty($role)): ?>
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
<?php endif; ?>

    <main class="cards-area container">
      <section class="cards">
        <article class="card">
          <div class="card-image"><img src="images/NRU.png" alt=" "></div>
          <div class="card-desc">
            <h3>Nitro Racers Unleashed</h3>
            <p>jeu de course automobile intense et rapide, 
              mettant en scène une voiture de sport ailée sur fond de paysage urbain au coucher du soleil, 
              symbolisant la vitesse et la liberté</p>
              <!-- Bouton ajouter aux favoris -->
              <form method="POST" action="favorite.php" style="margin-top:8px">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="jeu_id" value="1">
                <button class="btn-connect" type="submit">Mettre en favoris</button>
              </form>
          </div>
        </article>

        <article class="card">
          <div class="card-image"><img src="images/SDAC.png" alt=" "></div>
          <div class="card-desc">
            <h3>Sky Dominators Ace Combat</h3>
            <p>Plongez dans des batailles aériennes palpitantes où des as du pilotage s'affrontent 
              dans les cieux pour dominer l'espace aérien à travers des missions intenses et réalistes.</p>
            <form method="POST" action="favorite.php" style="margin-top:8px">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="jeu_id" value="2">
              <button class="btn-connect" type="submit">Mettre en favoris</button>
            </form>
          </div>
        </article>

        <article class="card">
          <div class="card-image"><img src="images/FLAS.png" alt="Mon jeu"></div>
          <div class="card-desc">
            <h3>Football Legends Ace Stiker</h3>
            <p>Vivez l'excitation du beau jeu en prenant le contrôle de votre équipe favorite, 
              en exécutant des tactiques complexes et en marquant des buts spectaculaires pour remporter la victoire.</p>
            <form method="POST" action="favorite.php" style="margin-top:8px">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="jeu_id" value="3">
              <button class="btn-connect" type="submit">Mettre en favoris</button>
            </form>
          </div>
        </article>

        <article class="card">
          <div class="card-image"><img src="images/FFCC.png" alt="Mon jeu"></div>
          <div class="card-desc">
            <h3>Fighting Fury Clash Of Champions</h3>
            <p>Maîtrisez un combattant unique doté de mouvements et de combos dévastateurs, 
              et défiez des adversaires dans des duels épiques où seule la force et la stratégie décident du vainqueur.</p>
            <form method="POST" action="favorite.php" style="margin-top:8px">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="jeu_id" value="4">
              <button class="btn-connect" type="submit">Mettre en favoris</button>
            </form>
          </div>
        </article>

      </section>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>

    <!-- Script pour la recherche de jeux -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    let input = this.value.toLowerCase();
                    let cards = document.querySelectorAll('.card');
                    
                    cards.forEach(function(card) {
                        let title = card.querySelector('.card-desc h3')?.textContent.toLowerCase() || '';
                        let description = card.querySelector('.card-desc p')?.textContent.toLowerCase() || '';
                        let text = title + ' ' + description;
                        
                        if (text.includes(input)) {
                            card.style.display = '';
                            card.style.animation = 'fadeIn 0.3s ease-in';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    checkNoResults(cards, input);
                });
            }
        });
        
        function checkNoResults(cards, input) {
            let visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
            let oldMessage = document.querySelector('.no-results-message');
            if (oldMessage) oldMessage.remove();
            
            if (visibleCards.length === 0 && input.trim() !== '') {
                let message = document.createElement('div');
                message.className = 'no-results-message';
                message.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 3rem; color: rgba(255, 255, 255, 0.7);';
                message.innerHTML = `
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">😔 Aucun jeu trouvé</h3>
                    <p>Aucun jeu ne correspond à "${input}"</p>
                `;
                document.querySelector('.cards').appendChild(message);
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>