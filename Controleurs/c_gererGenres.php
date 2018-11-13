<?php
require_once'Modele/GenreDal.class.php';
require_once'include/_reference.lib.php';

if(!isset($_REQUEST['action']))
{
  $action ='listerGenres';
}
else
{
  $action = $_REQUEST['action'];
}

// variables pour la gestion des messages
$titrePage = 'Gestion des genres';
// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;

// variables pour la gestion des messages
$msg=''; //msg passé à v_afficherMessages
$lien=''; //msg passé à v_afficherErreurs


// initialisation des variables
          $strCode = '';
          $strLibelle = '';

switch($action){
  case 'listerGenres' : {
    $lesGenres= GenreDal::loadGenres(1);
    $nbGenres = count($lesGenres);
    include("Vues/v_listeGenres.php");
  }
  break;
  case 'ajouterGenre' : {
    // traitement de l'option : saisie ou validation ?
          if (isset($_GET["option"])) {
              $option = htmlentities($_GET["option"]);
          } else {
              $option = 'saisirGenre';
          }
          switch ($option) {
                case 'saisirGenre' : {
                        include 'vues/v_ajouterGenre.php';
                    } break;
                case 'validerGenre' : {
                  // tests de gestion du formulaire
                  if (isset($_POST["cmdValider"])) {
                      // récupération du libellé
                      if (!empty($_POST["txtLibelle"])) {
                          $strLibelle = ucfirst(htmlentities($_POST["txtLibelle"]));
                      }
                      if (!empty($_POST["txtCode"])) {
                          $strCode = strtoupper(htmlentities($_POST["txtCode"]));
                      }
                      // test zones obligatoires
                      if (!empty($strCode) and !empty($strLibelle)) {
                          // les zones obligatoires sont présentes
                          // tests de cohérence
                          // contrôle d'existence d'un genre avec le même code
                          $doublon = GenreDal::loadGenreByID($strCode);
                          if ($doublon != NULL) {
                            // signaler l'erreur
                            $tabErreurs[] = 'Il existe déjà un genre avec ce code !';
                            $hasErrors = true;
                          }
                      }
                  else {
                    // une ou plusieurs valeurs n'ont pas été saisies
                    if (empty($strCode)) {
                        $tabErreurs[] = "Le code doit être renseigné !";
                    }
                    if (empty($strLibelle)) {
                        $tabErreurs[] = "Le libellé doit être renseigné !";
                    }
                    $hasErrors = true;
                  }
                  if(!$hasErrors){
                    $code=GenreDal::addGenre($strCode,$strLibelle);
                    if($code != NULL) {
                      $msg = 'Le genre'
                      .$strCode.'-'
                      .$strLibelle.' a été ajouté</span>';
                      include 'vues/_v_afficherMessage.php';
                      //include 'vues/v_consulterGenre.php';
                    }
                    else {
                      $tabErreurs[] = "Une erreur s\'est produite dans l\'opération d\'ajout !";
                      $hasErrors = true;
                    }
                  }
                  if($hasErrors){
                    $msg = "L'opération d'ajout n'a pas pu être menée à terme en raison des erreurs suivantes :";
                    $lien = '<a href="index.php?uc=gererGenres&action=ajouterGenre">Retour à la saisie</a>';
                    include 'vues/_v_afficherErreurs.php';
                  } //hasError = time

                } //cmdValider
          } //validerGenre
  } break; //switch $option
} //switch ajouterGenre

  break;
  case 'afficherGenre' : {

  }
  break;
  case 'modifierGenre' : {

  }
  break;
  case 'supprimerGenre' : {

  }
  break;
  case 'consulterGenre' : {

  }
  break;
  default : include"Vues/_v_home.php";
}
?>
