<?php
/**
 * Page d'accueil de l'application CAG

 * Point d'entrée unique de l'application
 * @author
 * @package default
 */

// inclure les bibliothèques de fonctions
require_once 'include/_config.inc.php';
session_start(); // début de session
// on simule un utilisateur connecté (en phase de test)
$_SESSION['id'] = 9999;
$_SESSION['nom'] = 'Dupont';
$_SESSION['prenom'] = 'Jean';

include("Vues/_v_header.php") ;
include("Vues/_v_menu.php") ;

if(isset($_REQUEST['uc'])){
  $uc = $_REQUEST['uc'];
}
else{$uc= 'home';}

switch($uc){
  case 'gererGenres' :include 'Controleurs/c_gererGenres.php'; break;
  case 'gererAuteurs' :include 'Controleurs/c_gererAuteurs.php'; break;
  case 'gererOuvrages' :include 'Controleurs/c_gererOuvrages.php'; break;
  default : include 'Vues/_v_home.php';
}

include("Vues/_v_footer.php") ;

?>
