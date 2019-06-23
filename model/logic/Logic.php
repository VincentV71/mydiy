<?php 

class Logic {

	/* Vérifie la validité d'une recette (correspondance des quantités et du dosage) 
	Lors d'une CREATION : lève une exception si non-conformité des quantités ou du dosage, void en cas de succès;
	Lors d'une MODIFICATION : calcule les nouvelles proportions (base et arome), met à jour l'objet Recette et le renvoie en cas de succès;
	*/
	public static function recetteValid(array $data, Recette $recet){
		// CREATION d'une Recette :
		if (isset($data['QTE_ARO']) && isset($data['QTE_BAS']) && isset($data['QTE_TOT']) && isset($data['DOS_ARO'])){
			$aro = (float)(str_replace(",", ".", $data['QTE_ARO']) );
			$bas = (float)(str_replace(",", ".", $data['QTE_BAS']) );
			$tot = (float)(str_replace(",", ".", $data['QTE_TOT']) );
			$dos = (float)(str_replace(",", ".", $data['DOS_ARO']) );
			if ( $aro + $bas != $tot ) throw new Exception ("la quantité totale doit être la somme des quantités 'Arôme' et 'Base'.");
 			if ( $aro != round($tot*($dos/100), 1 ) ) throw new Exception ("ce dosage ne correspond pas aux quantités 'Arôme' et 'Base' saisies.");
		}
		// MODIFICATION d'une Recette :
		if (isset($data['ATTRIBUTE'])){
			$aro = (float)($recet->qteAro());
			$bas = (float)($recet->qteBase());
			$tot = (float)($recet->qteTot());
			if ($tot <= $bas) throw new Exception ("la quantité 'Base' doit être inférieure à la quantité totale de la recette");
			if ($tot <= $aro) throw new Exception ("la quantité 'Arôme' doit être inférieure à la quantité totale de la recette");
			if ($data['ATTRIBUTE'] == 'QTE_ARO'){
				$newBas = $tot-$aro ;
				$recet->setQTE_BAS($newBas);
			}
			if ($data['ATTRIBUTE'] == 'QTE_BAS'){
				$newAro = $tot-$bas ;
				$recet->setQTE_ARO($newAro);
			}
			return $recet;
		}
	}

	/* Calcule le dosage d'après les quantités d'une recette ; Met à jour l'objet Parfumer et le renvoie en cas de succès :
	*/
	public static function dosageValid(array $data, Recette $recet, Parfumer $parfumer){
		// MODIFICATION d'une Recette :
		if (isset($data['ATTRIBUTE'])){
			$aro = (float)($recet->qteAro());
			$bas = (float)($recet->qteBase());
			$tot = (float)($recet->qteTot());
			$dos = (float)($parfumer->dos());
			
			if ( $aro != $tot*($dos/100) ){
				$newDos = round( ($aro/$tot)*100, 1 ) ;
				$parfumer->setDOS_ARO($newDos);
			}
			return $parfumer;
		}
	}

	// Vérifie que la somme VG et PG d'une base est égale à 100 :
	public static function baseValid(array $data, Base $base){
		// CREATION d'une Base :
		if (isset($data['DOS_PG']) && isset($data['DOS_VG']) ){
			$pg = (int)($data['DOS_PG']) ;
			$vg = (int)($data['DOS_VG']) ;
			if ( $pg + $vg != 100 ) throw new Exception ("la somme des proportions 'VG' et 'PG' n'est pas égale à 100");
		}

		// MODIFICATION d'une Base :
		if (isset($data['ATTRIBUTE'])){
			$pg = (int)($base->pg());
			$vg = (int)($base->vg());
			if ($data['ATTRIBUTE'] == 'DOS_PG'){
				$newVg = 100-$pg ;
				$base->setDOS_VG($newVg);
			}
			if ($data['ATTRIBUTE'] == 'DOS_VG'){
				$newPg = 100-$vg ;
				$base->setDOS_PG($newPg);
			}
			return $base;
		}
	}

	/* Pour toutes les clés de l'array reçu qui contiennent un ID, vérifie que la valeur existe en
	BDD ; renvoie true si tous les ID transmis existent, sinon lève une exception :
	*/ 
	public static function allIdExist(array $donnees){
		$pk = array ("Arome"=>"ID_ARO", "User"=>"ID_USER", "Recette"=>"ID_RECET", "Base"=>"ID_BASE", "Prix"=>"ID_PRIX", "Avis"=>"ID_AVIS");
		foreach ($donnees as $key => $value) {
			if (explode("_", $key)){
				$keyExploded = explode("_", $key);
				// Si la clé commence par "ID" :
				if ($keyExploded[0] == "ID"){
					foreach ($pk as $libelleTable => $champ) {
						if ($key == $champ){
							// Instanciation du Manager :
							$classManager = ($libelleTable).'Manager';
							$myObjectManager = new $classManager;
							// Vérifie l'existance de l'ID :
							$idExist = $myObjectManager->checkId($value);
							if ($idExist == false) throw new Exception("l'ID (table ".$libelleTable.") que vous avez saisi n'existe pas actuellement.");
						}
					}
				}
			}
		}
		return true; // tous les ID existent en BDD !
	}
}
?>