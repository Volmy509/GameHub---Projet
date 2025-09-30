<!-- NavBar border radius, shadow box, profil a gauche, rechercher un jeu au centre, se deconnecter/se conecter a droit etoiles avec les favoris -->
  <?php session_start(); 
  
  if (!isset($_SESSION['role'])) {
    header('Location: index.php');
    exit();
}

$role = $_SESSION['role']

  ?>

  <!DOCTYPE html>
  <html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🕹️ GameHub </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>

  <body>
    <?php if($role==='Visiteur'):?>
       
    <body>
    <?php if($role==='Joueur'):?>


    <body>
    <?php if($role==='Admin'):?>
        
        












<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
  </html>