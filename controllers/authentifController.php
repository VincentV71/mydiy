<?php
session_start();
require __DIR__ . '../../vues/static/bibliotheque.php';
require __DIR__ . '../../model/User.php';
require __DIR__ . '../../model/managers/Manager.php';
require __DIR__ . '../../model/managers/UserManager.php';
require __DIR__ . '/validators/ValidatorFactory.php';
require __DIR__ . '../../model/logic/Logic.php';

try {
	$myUserManager = new UserManager ;
	// INSCRIPTION :
	if(isset($_POST['forminscription'])){
		if (empty ($_POST['pseudo']) OR empty ($_POST['pass']) 
			OR empty ($_POST['mail']) OR empty ($_POST['confpass']))
				throw new Exception("vous n'avez pas rempli TOUS les champs"); 
		else {
			if ($_POST['pass'] != $_POST['confpass'])
				throw new Exception("le mot de passe et sa confirmation doivent être identiques");
			else {
				if (!(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)))
					throw new Exception("cette adresse e-mail n'est pas valide");
				else {
					// Vérifie que le pseudo et l'email n'existent pas en BDD :
					$myUserManager->checkEmailAndNom($_POST['mail'], $_POST['pseudo']);

					$_POST['NOM_USER'] = $_POST['pseudo'];
					$_POST['MAIL_USER'] = $_POST['mail'];
					$_POST['PASSWD'] = $_POST['pass'];
					$_POST['AFF_USER'] = "oui";
					// Vérifie la validité des datas saisies :
					ValidatorFactory::control ($_POST, 'User');

					$user = new User($_POST);
					// Insert en BDD :
					$myUserManager->insert($user);
					$_SESSION['inscriptionMsg'] = "Bravo ".$_POST['NOM_USER']." , vous êtes désormais inscrit";
					$_SESSION['classMsg'] = "success";
					header("Location: ../vues/inscription.php");
					}		
				}
			}
		}

		// CONNEXION :
		if(isset($_POST['formconnexion'])){
			if (empty ($_POST['mailconnect']) OR empty ($_POST['mdpconnect']) )
				throw new Exception("vous n'avez pas rempli TOUS les champs"); 
			else {
				if (!(filter_var($_POST['mailconnect'], FILTER_VALIDATE_EMAIL)))
					throw new Exception("cette adresse e-mail n'est pas valide");
				else {
					$_POST['mailconnect']= htmlspecialchars($_POST['mailconnect']);
					$_POST['mdpconnect'] = sha1(htmlspecialchars($_POST['mdpconnect']) );
					// vérification  en BDD, récupération  :
					$dataUser = $myUserManager->authentificate($_POST['mailconnect'], $_POST['mdpconnect']);
					if ($dataUser[0]["ID_USER"] && $dataUser[0]["NOM_USER"]) {
						$_SESSION['nom'] = $dataUser[0]["NOM_USER"];
						$_SESSION['id'] = $dataUser[0]["ID_USER"];
						if ( (int) ($_SESSION['id']) === 1) header("Location: ../vues/admin.php");
						if ( (int) ($_SESSION['id']) > 1) header("Location: ../vues/mes_recettes.php");
					}
				}
			}
		}
	}
catch(Exception $e){
	if(isset($_POST['forminscription'])) {
	    $_SESSION['inscriptionMsg'] = "Votre inscription a échouée car ".($e->getMessage() );
	    $_SESSION['classMsg'] = "danger";
	    header("Location: ../vues/inscription.php");
    }
    if(isset($_POST['formconnexion'])) {
	    $_SESSION['connexionMsg'] = "Votre authentification a échouée car ".($e->getMessage() );
	    $_SESSION['classMsg'] = "danger";
	    header("Location: ../vues/connexion.php");
    }
}
?>


