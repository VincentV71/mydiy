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
$propertiesData = json_decode(file_get_contents(__DIR__ .'../../model/json/dataDefinitions.json'), true);

try{
	// Si id de session existe :
	if (!$_SESSION['id'] || is_null($_SESSION['id']) || !isset($_SESSION['id']) || !is_string($_SESSION['id']) ){
		throw new Exception("vous devez d'abord vous reconnecter");
	}
	// Si id de session convertible en Int et =1 (Admin):
	$idUser = htmlspecialchars($_SESSION['id']);
	$idUser = (int)$idUser;
	if ($idUser != 1){
		throw new Exception("connectez-vous en mode Administrateur");
	}
	// Si 'action' et 'table' sont définis, récupère les valeurs, vide les 2 clés/valeurs:
	if (!$postData['ACTION']) throw new Exception("aucune action n'est renseignée.");
	if (!$postData['TABLE']) throw new Exception("aucune action n'est renseignée.");
	$action = (int) (htmlspecialchars($postData['ACTION']) );
	$table = (int) (htmlspecialchars($postData['TABLE']) );
	$libelleTable = ucfirst(strtolower($propertiesData[$table]['label']));
	unset($postData['ACTION']);
	unset($postData['TABLE']);

	// Si toutes les clés contiennent une valeur :
	foreach ($postData as $value) {
	    if ( is_null($value) ) throw new Exception("une des valeurs n'est pas renseignée.");
	}

	$attributesToSet = [];

	// Action = AFFICHER :
	if ($action === 0) throw new Exception("vous avez sélectionné 'Afficher' : aucun enregistrement n'a été réalisé");

	// Instanciation du Manager :
	$classManager = ($libelleTable).'Manager';
	$myObjectManager = new $classManager;

	// Action = CREER :
	if ($action === 1){
		// Vérifie que chaque valeur à renseigner (show=true) est présente :
		for ($i=0; $i < sizeof($propertiesData[$table]['attribut']); $i++){
			if ($propertiesData[$table]['attribut'][$i]["SHOW"] == 'true')
				array_push($attributesToSet, $propertiesData[$table]['attribut'][$i]["NAME"]);
		}
		if ($table == 3 && $postData['ID_ARO'] && $postData['DOS_ARO']) array_push($attributesToSet, $postData['ID_ARO'], $postData['DOS_ARO']);
		if (sizeof($postData) != sizeof($attributesToSet) )throw new Exception("tous les champs doivent être renseignés");

		// Gestion des Dates (table RECETTE(3) et AVIS(6)):
		if ($table === 3 || $table === 6){
			$today = new DateTime ();
			$today = $today->format('Y-m-d');//Format Date pour MySql
			if ($table === 3) {
				// Récupère l'ID Arome, puis NB J STEEP, calcule la date fin de steep :
				$aromeSelected = $postData['ID_ARO'];
				$dosageSelected = $postData['DOS_ARO'];
				$my_arome_manager = new AromeManager();
				$nbJourSteep = $my_arome_manager->getSteep($aromeSelected);
				$steep = new DateTime ('+'.$nbJourSteep.' day');
				$steep = $steep->format('Y-m-d');//Format Date pour MySql
				// Entre les dates dans le tableau :
				$postData['DAT_RECET'] = $today;
				$postData['DAT_STEE'] = $steep;
			}
			else $postData['DATE_AVI'] = $today; // Table Avis
		}

		Logic::allIdExist($postData);
		ValidatorFactory::control ($postData, $libelleTable);
		$myObject = new $libelleTable ($postData);

		if ($table != 3){
			if ($table === 7){ // Création en table Base
				Logic::baseValid($postData, $myObject);
			}
			$myObjectManager->insert($myObject);
		}
		if ($table === 3){ // Transaction avec Objets Recette et Parfumer 
			ValidatorFactory::control ($postData, 'Parfumer');
			Logic::recetteValid($postData, $myObject);
			$myObjectParfumer = new Parfumer ($postData);
			$myObjectManager->insert($myObject, $myObjectParfumer);
		}
	}

	// Si action = MODIFIER ou SUPPRIMER :
	if ($action === 2 || $action === 3){
		// récupération de l'ID primary key, mise à jour de sa clé dans $postData:
		$idPk = $postData['ID_SELECTED'];
		unset($postData['ID_SELECTED']);
		$idName = $propertiesData[$table]['attribut'][0]["NAME"];
		$postData[$idName] = $idPk;
		Logic::allIdExist($postData);

		// Action = MODIFIER
		if ($action === 2){
			// Select l'entrée BDD avec son ID (PK), instancie un objet :
			$reqRetour = $myObjectManager->select($idPk);
			$reqRetour = $reqRetour->fetchAll();
      		$myObject = new $libelleTable($reqRetour[0]);
			// Teste la nouvelle valeur avec le Validator:
			ValidatorFactory::control ($postData, $libelleTable);
			// Set la nouvelle valeur sur l'objet :  
			$champToUpdate = $postData['ATTRIBUTE'];
			$method = "set".($champToUpdate);
			$myObject->$method($postData[$champToUpdate]);

			// Si modification des proportions d'une Base :
			if ($table === 7 && ($champToUpdate == "DOS_VG" || $champToUpdate == "DOS_PG") ){ 
				$myObject = Logic::baseValid($postData, $myObject);
			}
			// Si modification des proportions d'une recette :
			if ($table === 3 && ($champToUpdate == "QTE_ARO" || $champToUpdate == "QTE_BAS") ) {
				// Mise à jour des proportions de la recette :
				$myObject = Logic::recetteValid($postData, $myObject);
				// Instanciation de l'objet Parfumer associé à la recette à modifier :
				$myParfumerManager = new ParfumerManager;
				$reqRetour = $myParfumerManager->select($idPk);
				$reqRetour = $reqRetour->fetchAll();
	      		$myObjectParfumer = new Parfumer($reqRetour[0]);
				// Vérification de la recette, mise à jour de l'objet Parfumer si succès :
				$myObjectParfumer = Logic::dosageValid($postData, $myObject, $myObjectParfumer);
				// Vérification de la validité du dosage :
				$postData['DOS_ARO'] = $myObjectParfumer->dos();
				ValidatorFactory::control ($postData, "Parfumer");
				// Exécute en BDD (Transaction) : 
				$myObjectManager->updateTransac($myObject, $myObjectParfumer);
			}
			else  
				// Exécute Simple Update en BDD
				$myObjectManager->update($myObject);
		}

		// Action = SUPPRIMER
		if ($action === 3){
			// Lit la BD, instancie l'objet
			$reqRetour = $myObjectManager->select($idPk);
			$reqRetour = $reqRetour->fetchAll();
      		$myObject = new $libelleTable($reqRetour[0]);
      		// Exécute un Delete en BDD
			$myObjectManager->delete($myObject);
		}
	}
	// Message final si tout est réussi
	echo 'success';
} 

catch(Exception $e){
    echo "Votre saisie n'a pas été enregistrée car ".($e->getMessage() );
}
?>
