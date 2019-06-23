<?php  
session_start();
error_reporting(E_ALL ^ E_NOTICE); // important pour ne pas afficher les notice PHP sans cela le script ne marche pas.

require __DIR__ . '../../managers/Manager.php';
require __DIR__ . '../../managers/AromeManager.php';
require __DIR__ . '../../managers/BaseManager.php';
require __DIR__ . '../../managers/AvisManager.php';
require __DIR__ . '../../managers/ParfumerManager.php';
require __DIR__ . '../../managers/PrixManager.php';
require __DIR__ . '../../managers/RecetteManager.php';
require __DIR__ . '../../managers/UserManager.php';

	// Renvoie au format JSON les entrées d'une table de la BDD :
	
	if (isset($_GET['table'])){
		$classManager = ($_GET['table']).'Manager';
		$myObjectManager = new $classManager;

		$data = $myObjectManager->selectAll();
		$data = $data->fetchAll();
		echo json_encode($data, JSON_NUMERIC_CHECK) ; 
	}   
?>
