<?php
session_start();
require __DIR__ . '../../vues/static/bibliotheque.php';  
require __DIR__ . '../../model/Recette.php';
require __DIR__ . '../../model/managers/Manager.php';
require __DIR__ . '../../model/managers/RecetteManager.php';
require __DIR__ . '../../model/managers/UserManager.php';
require __DIR__ . '/validators/ValidatorFactory.php';
require __DIR__ . '../../model/logic/Logic.php';

try{
	// Réactiver une recette :
	if ( isset($_POST['reveil_recette']) ) header("Location: ../vues/mes_recettes_inactives.php");

	// Si id de session existe :
	if (!$_SESSION['id'] || is_null($_SESSION['id']) || !isset($_SESSION['id']) || !is_string($_SESSION['id']) || (int)($_SESSION['id'])<1 )
		throw new Exception("vous devez d'abord vous reconnecter");

	// Si id recette existe :
	if (isset( $_POST['ID_RECET']) ){
		$idUser = (int)($_SESSION['id']);
		$_POST['ID_USER']= $idUser;
		$idRecette = $_POST['ID_RECET'];

		// Vérification des ID :
		Logic::allIdExist($_POST);

		// Instanciation du Manager :
		$myRecetteManager = new RecetteManager;

		// Select l'entrée BDD, instancie un objet :
		$reqRetour = $myRecetteManager->select($_POST['ID_RECET']);
		$reqRetour = $reqRetour->fetchAll();
		$recette = new Recette($reqRetour[0]);
		// Teste la conformité de la nouvelle valeur avec le Validator:
		ValidatorFactory::control ($_POST, 'Recette');

		// Set la nouvelle valeur sur l'objet :  
		if ( isset($_POST['ETOILES']) ) $recette->setETOILES($_POST['ETOILES']);
		if ( isset($_POST['COM_USER']) ) $recette->setCOM_USER($_POST['COM_USER']);
		if ( isset($_POST['ETA_STEE']) ) $recette->setETA_STEE($_POST['ETA_STEE']);
		if ( isset($_POST['AFF_RECET']) ) $recette->setAFF_RECET($_POST['AFF_RECET']);

		// Exécute Simple Update en BDD
		$myRecetteManager->update($recette);
		header("Location: ../vues/mes_recettes.php");
	}
}
catch(Exception $e){
    $_SESSION['mes_recettesError'] = "Votre saisie n'a pas été enregistrée car ".($e->getMessage() );
    header("Location: ../vues/mes_recettes.php");
}
?>


