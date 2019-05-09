<?php
// session_start();
function nbActive($str){
	if($str<2){
		echo("recette active.");
	}
	else echo("recettes actives.");
};

function nbInactive($str){
	if($str<2){
		echo("recette inactive.");
	}
	else echo("recettes inactives.");
};

// Transforme les valeurs ",0" et ".0" en entiers :
function formateFloat(array $donnees){
	foreach ($donnees as $key => $value) {
	 	if (is_numeric($value) && intval($value) == floatval($value)){
	 		$donnees[$key] = intval($value);
	 	}
	 	if (is_numeric($value)){
	 		$donnees[$key] = str_replace('.',',',$donnees[$key]);
	 	}  
	}
	return $donnees; 
}

function deconnectUser (){
	// Détruit toutes les variables de session
	$_SESSION = array();
	// Efface le cookie de session.
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	// Détruit la session.
	session_destroy();
}

?>
