<?php 
session_start();
require __DIR__ . '../../vues/static/bibliotheque.php';  
require __DIR__ . '../../model/managers/Manager.php';
require __DIR__ . '../../model/managers/AromeManager.php';
require __DIR__ . '../../model/managers/BaseManager.php';
require __DIR__ . '../../model/managers/AvisManager.php';
require __DIR__ . '../../model/managers/ParfumerManager.php';
require __DIR__ . '../../model/managers/PrixManager.php';
require __DIR__ . '../../model/managers/RecetteManager.php';
require __DIR__ . '../../model/managers/UserManager.php';
require __DIR__ . '../../model/logic/Logic.php';
require __DIR__ . '../../model/Arome.php';
require __DIR__ . '../../model/Base.php';
require __DIR__ . '../../model/Avis.php';
require __DIR__ . '../../model/Parfumer.php';
require __DIR__ . '../../model/Prix.php';
require __DIR__ . '../../model/Recette.php';
require __DIR__ . '../../model/User.php';
require __DIR__ . '/validators/ValidatorFactory.php';

$postData = json_decode(file_get_contents('php://input'), true);

try{
	// Si id de session existe :
	if (!$_SESSION['id'] || is_null($_SESSION['id']) || !isset($_SESSION['id']) || !is_string($_SESSION['id']) || (int)($_SESSION['id'])<1 )
		throw new Exception("vous devez d'abord vous reconnecter");
	
	$idUser = htmlspecialchars($_SESSION['id']);
	$idUser = (int)$idUser;
	$postData['ID_USER'] = $idUser;
	
	// Si toutes les clés contiennent une valeur :
	foreach ($postData as $value) {
	    if ( is_null($value) ) throw new Exception("une des valeurs n'est pas renseignée.");
	}
	
	// Gestion des DATES :
	$today = new DateTime ();
	$today = $today->format('Y-m-d');//Format Date pour MySql
	
	// Récupère l'ID Arome, puis NB J STEEP, calcule la date fin de steep :
	$aromeSelected = $postData['ID_ARO'];
	$dosageSelected = $postData['DOS_ARO'];
	$myAromeManager = new AromeManager();
	$nbJourSteep = $myAromeManager->getSteep($aromeSelected);
	$steep = new DateTime ('+'.$nbJourSteep.' day');
	$steep = $steep->format('Y-m-d');//Format Date pour MySql
	// Entre les dates dans le tableau :
	$postData['DAT_RECET'] = $today;
	$postData['DAT_STEE'] = $steep;
	$postData['ETA_STEE'] = "STEEP";
	$postData['AFF_RECET'] = "oui";
	$postData['COM_USER'] = "";
	$postData['ETOILES'] = "";
		
	// Contrôles, instanciations des objets :
	Logic::allIdExist($postData);
	ValidatorFactory::control ($postData, 'Recette');
	$myRecette = new Recette ($postData);
	
	ValidatorFactory::control ($postData, 'Parfumer');
	Logic::recetteValid($postData, $myRecette);
	$myParfumer = new Parfumer ($postData);

	// Transaction avec Objets Recette et Parfumer :
	$myRecetteManager = new RecetteManager;
	$myRecetteManager->insert($myRecette, $myParfumer);

	// Message final si tout est réussi
	echo 'success';
} 
catch(Exception $e){
    echo "Votre saisie n'a pas été enregistrée car ".($e->getMessage() );
}
?>
