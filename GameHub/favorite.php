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

// Vérifier si l'utilisateur est connecté et est un joueur
if ($role !== 'joueur' || !isset($_SESSION['joueur_id'])) {
    header('Location: login.php');
    exit();
}
   $joueur_id = $_SESSION['joueur_id'];

// Gérer l'ajout aux favoris
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action'], $_POST['jeu_id']) &&
    $_POST['action'] === 'add'
) {
    $jeu_id = (int) $_POST['jeu_id'];

    // Vérifier les doublons avant insertion
    $chk = $pdo->prepare(
        'SELECT ID FROM favoris WHERE joueur_id = :j AND jeu_id = :g'
    );
    $chk->execute([
        'j' => $joueur_id,
        'g' => $jeu_id
    ]);

    if ($chk->fetch()) {
        $_SESSION['flash'] = [
            'type' => 'info',
            'message' => "Le jeu est déjà dans vos favoris."
        ];
        header('Location: favorite.php');
        exit();
    }

    //Insertion
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO favoris (joueur_id, jeu_id)
             VALUES (:joueur_id, :jeu_id)"
        );
        $stmt->execute([
            ':joueur_id' => $joueur_id,
            ':jeu_id'    => $jeu_id
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Jeu ajouté aux favoris ✅"
        ];
    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Erreur lors de l'ajout aux favoris."
        ];
    }

    header('Location: favorite.php');
    exit();
}

   
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🕹️ GameHub - Mes Favoris</title>
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
            text-decoration: none;
            display: inline-block;
        }

        .btn-connect:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width:1200px;
            margin:6.5rem auto 2rem;
        }

        .page-title {
            margin:1rem 0 1.5rem;
            font-size:1.4rem;
            color:#fff;
            text-align:left;
        }

        /* Cards grid */
        .cards-area {
            margin-top:2rem;
        }

        .cards-title {
            color:#fff;
            margin-bottom:1rem;
        }

        .cards {
            display:grid;
            grid-template-columns: repeat(auto-fill,minmax(240px,1fr));
            gap:1.1rem;
        }

        .card {
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

        .card:hover {
            transform: translateY(-8px);
            box-shadow:0 18px 40px rgba(2,6,23,0.7);
        }

        .card-image {
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

        .card-desc {
            margin-top:auto;
            padding:14px;
            background: linear-gradient(180deg, rgba(0,0,0,0.0), rgba(0,0,0,0.45));
            color:#fff;
            backdrop-filter: blur(6px);
        }

        .card-desc h3 {
            margin:0 0 6px;
            font-size:1.05rem;
        }

        .card-desc p {
            margin:0;
            font-size:0.9rem;
            opacity:0.95;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Responsive tweaks */
        @media (max-width:520px) {
            .card-image {
                height:130px;
            }
            .cards {
                gap:.8rem;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span>GAME HUB</span>
            </a>
              
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher un jeu">
            </div>

            <a href="index.php" class="btn-connect">Accueil</a>
            <a href="favorite.php" class="btn-connect">Mes Favoris</a>
            <a href="logout.php" class="btn-connect">Se déconnecter</a>
        </div>
    </nav>

    <div class="container">

        <section class="cards-area">
            <h2 class="cards-title">Vos jeux favoris</h2>
            <div class="cards">
                <?php
                try {
                    $stmt = $pdo->prepare("SELECT j.Nom, j.Synopsis, j.ImageUrl 
                                          FROM jeux j
                                          INNER JOIN favoris f ON j.ID = f.jeu_id
                                          WHERE f.joueur_id = :joueur_id");
                    $stmt->bindParam(':joueur_id', $joueur_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (count($favoris) > 0) {
                        foreach ($favoris as $jeu): ?>
                            <article class="card">
                                <div class="card-image">
                                    <img src="<?php echo htmlspecialchars($jeu['ImageUrl']); ?>" 
                                         alt="<?php echo htmlspecialchars($jeu['Nom']); ?>">
                                </div>
                                <div class="card-desc">
                                    <h3><?php echo htmlspecialchars($jeu['Nom']); ?></h3>
                                    <p><?php echo htmlspecialchars($jeu['Synopsis']); ?></p>
                                </div>
                            </article>
                        <?php endforeach;
                    } else {
                        echo '<div class="empty-state">
                                <h3>Aucun jeu favori</h3>
                                <p>Vous n\'avez pas encore ajouté de jeux à vos favoris.</p>
                              </div>';
                    }
                } catch (PDOException $e) {
                    echo '<div class="empty-state">
                            <h3>Erreur</h3>
                            <p>Impossible de charger vos favoris: ' . htmlspecialchars($e->getMessage()) . '</p>
                          </div>';
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>