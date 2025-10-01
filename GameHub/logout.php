<!-- PAGE LOGOUT PERMET AUX UTILISATEUR CONNECTER DE SE DECONECTER ET DONC DE PASSER EN MODE "VISITEUR"-->
 <?php
session_start();
session_destroy();
header('location: index.php');

?>