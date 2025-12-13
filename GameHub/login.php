<!-- PAGE DE CONNEXION HTML/PHP
 PERMET LA CONNEXION DE L'ENSEMBLE DES UTILISATEUR IDENTIFIANT + MOT DE PASSE *mot de passe oublié + Bouton se connecter -->
  <?php session_start(); 

  //Connexion a la base de données 
  $host = 'localhost';
  $dbname = 'GameHub';
  $user = 'root'; // A modifier pour déploiement
  $pass = ''; // A modifier pour déploiement

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = htmlspecialchars(trim($_POST['identifiant'] ?? ''));
    $Motdepasse = trim($_POST['Motdepasse'] ?? '');

    if (!empty($identifiant) && !empty($Motdepasse)) {
        // Préparer et exécuter la requête
        $stmt = $pdo->prepare("SELECT * FROM joueurs WHERE identifiant = :identifiant");
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($Motdepasse, $user['Motdepasse'])) {
            session_regenerate_id(true);
            
            $_SESSION['joueur_id'] = $user['ID'];
            $_SESSION['identifiant'] = $user['identifiant'];
            $_SESSION['role'] = $user['role'];

            header('Location: index.php');
            exit();
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => "Nom d'utilisateur ou mot de passe incorrect."];
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => "Veuillez remplir tous les champs."];
        header('Location: login.php');
        exit();
    }
}

  ?>

  <!DOCTYPE html>
  <html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🕹️ Game-Hub </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  
  <body>
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Game Hub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #000a97ff 0%, #b918c8ff 100%);
            z-index: -2;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            animation: float linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .logo-icon i {
            font-size: 40px;
            color: white;
        }

        .logo-section h1 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .logo-section p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 10;
        }

        .form-control {
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
        }


        .signup-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="animated-bg" id="particles"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h1>Game Hub</h1>
                <p>Connectez-vous pour continuer</p>
            </div>

            <form id="loginForm" method="POST" action="login.php">
                
                <?php if (isset($_SESSION['flash'])): ?>
        <?php $f = $_SESSION['flash']; ?>
        <div class="alert alert-<?= ($f['type'] === 'success') ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($f['message']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

                <div class="form-group">
                    <label class="form-label">Identifiant</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" name="identifiant" placeholder="Entrez votre identifiant" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" name="Motdepasse" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>

                <div class="forgot-password">
                    <a href="#"><i class="fas fa-question-circle"></i> Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>

            <div class="signup-link">
                Pas encore de compte ? <a href="register.php">Créer un compte</a>
            </div>
        </div>
    </div>

    <script>
        // Création des particules animées
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            const size = Math.random() * 5 + 2;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particle.style.animationDelay = Math.random() * 5 + 's';
            
            particlesContainer.appendChild(particle);
        }

    </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
  </html>