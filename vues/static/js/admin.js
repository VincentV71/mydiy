var monAppAdmin = angular.module('adminApp', []);
monAppAdmin.controller('adminCtrl', function($scope, $http) {

	// Récupère chaque table en json :
	var getAllTables = function(){
		$http.get("../model/json/getJson.php?table=Arome")
		 .then(function (response) {
		 	$scope.dataArome = response.data;
		 });

		$http.get("../model/json/getJson.php?table=Base")
		 .then(function (retour) {
		 	$scope.dataBase = retour.data;
		});

		$http.get("../model/json/getJson.php?table=Avis")
		 .then(function (retour) {
		 	$scope.dataAvis = retour.data;
		});

		$http.get("../model/json/getJson.php?table=Parfumer")
		 .then(function (retour) {
		 	$scope.dataParfumer = retour.data;
		});

		$http.get("../model/json/getJson.php?table=Prix")
		 .then(function (retour) {
		 	$scope.dataPrix = retour.data;
		});

		$http.get("../model/json/getJson.php?table=User")
		 .then(function (retour) {
		 	$scope.dataUser = retour.data;
		});

		$http.get("../model/json/getJson.php?table=Recette")
		 .then(function (retour) {
		 	$scope.dataRecette = retour.data;
		});
	};

	// Récupération des datas de contrôle en JSON :
	$http.get("../model/json/forAdmin.json")
	 .then(function (retour) {
	 	$scope.dataAdmin = retour.data;
	});

	// Récupération des données en BDD via JSON :
	getAllTables();

	// Déclaration des variables :
	var dataToPost;
	var idSelect, idTable;
	$scope.tag = false;
	$scope.msg = "";
	$scope.msgErrorModif = "";
 	$scope.tagErrorModif = false;
 	$scope.msgErrorCrea = [];
	$scope.tagErrorCrea = [];
	$scope.tagErrorAttribut = false;
 	$scope.crea = [];
	$scope.msgConfirm = "";

	// Parse l'ID saisi en Int, vérifie que la valeur (Primary Key) existe dans la table :
 	$scope.checkId = function(){
 		$scope.msgConfirm = "";
 		if ($scope.selected_id){
	 		$scope.selected_id = parseInt($scope.selected_id);
	 		idSelect = $scope.selected_id ;
	 		idTable = $scope.choix_table ;
	 		$scope.tagIdExist = false;
	 		switch (idTable) {
			  case '2':
			    for (var i = 0; i < $scope.dataUser.length; i++) {
				    if (idSelect == $scope.dataUser[i].ID_USER) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			  case '3' :
			  	for (var i = 0; i < $scope.dataRecette.length; i++) {
				    if (idSelect == $scope.dataRecette[i].ID_RECET) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			  case '4':
			    for (var i = 0; i < $scope.dataArome.length; i++) {
				    if (idSelect == $scope.dataArome[i].ID_ARO) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			    case '5':
			    for (var i = 0; i < $scope.dataPrix.length; i++) {
				    if (idSelect == $scope.dataPrix[i].ID_PRIX) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			    case '6':
			    for (var i = 0; i < $scope.dataAvis.length; i++) {
				    if (idSelect == $scope.dataAvis[i].ID_AVIS) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			    case '7':
			    for (var i = 0; i < $scope.dataBase.length; i++) {
				    if (idSelect == $scope.dataBase[i].ID_BASE) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			    case '8':
			    for (var i = 0; i < $scope.dataParfumer.length; i++) {
				    if (idSelect == $scope.dataParfumer[i].ID_RECET) {
				    	$scope.tagIdExist = true;
				    }
				}
			    break;
			    // Reset Selected_id si 'toutes les tables' ou aucune table sélectionnée :
			  	default:
			  	$scope.selected_id = undefined ;
			}
		}
 	} 
 	// Récupère les datas de contrôle pour le champ sélectionné :
 	$scope.setAttribut = function(attribut){
 		if (attribut && $scope.choix_table){
 			for (var i = 0; i < $scope.dataAdmin[$scope.choix_table].attribut.length; i++){
 			  if (attribut == $scope.dataAdmin[$scope.choix_table].attribut[i].NAME){
	 			  this.attribut_type = $scope.dataAdmin[$scope.choix_table].attribut[i].TYPE;
	 			  this.attribut_min = $scope.dataAdmin[$scope.choix_table].attribut[i].MIN;
	 			  this.attribut_max = $scope.dataAdmin[$scope.choix_table].attribut[i].MAX;
	 			  this.attribut_step = $scope.dataAdmin[$scope.choix_table].attribut[i].STEP;
	 			  this.attribut_minlength = $scope.dataAdmin[$scope.choix_table].attribut[i].MINLENGTH;
	 			  this.attribut_maxlength = $scope.dataAdmin[$scope.choix_table].attribut[i].MAXLENGTH;
	 			  this.attribut_label = $scope.dataAdmin[$scope.choix_table].attribut[i].LABEL;
	 			  this.attribut_regex = new RegExp($scope.dataAdmin[$scope.choix_table].attribut[i].REGEX);
	 			}
 			}
 		}
 		if (this.saisie_modif){
	 		this.saisie_modif = "";
	 		$scope.formAdmin.saisie_modif.$setPristine(true);
	 		$scope.formAdmin.saisie_modif.$setUntouched(true);
 		}
 		if (this.attribut_modif){
 			$scope.tagErrorAttribut = false;
 		}
 	}
 	// Tri les champs, appelle les fonctions de vérification : 
 	$scope.verifSaisie = function(champ, valeur){
 		$scope.msgConfirm = "";
 		var prefix, suffix, champ_split ;
 		if (champ.split('_')){
 			champ_split = champ.split('_');
 			prefix = champ_split[0];
 			suffix = champ_split[1];
 			switch (prefix){
 				case 'ID' :
 					if (valeur && $scope.checkExistingId(suffix, valeur) == false){
						$scope.msg = "Cet ID n'existe pas";
	 					$scope.tag = true;
					}
					else {
						$scope.tag = $scope.verifRegEx(valeur, this.attribut_regex, 
 						this.attribut_min, this.attribut_max, this.attribut_minlength, this.attribut_maxlength);
					}
 				break;
				case 'AFF' :
					if (valeur) valeur = valeur.toLowerCase();
					if (valeur != "oui" && valeur != "non"){
						$scope.msg = "La saisie n'est pas conforme";
	 					$scope.tag = true;
					}
					else {
						$scope.msg = "";
						$scope.tag = false;
					}
 				break;
 				case 'ETA' :
 					if (valeur) valeur = valeur.toUpperCase();
 					if (valeur === "PRÊTE") valeur = "PRETE";
 					if (valeur != "STEEP" && valeur != "PRETE" && valeur != "FINIE"){
						$scope.msg = "La saisie n'est pas conforme";
	 					$scope.tag = true;
					}
					else {
						$scope.msg = "";
						$scope.tag = false;
					}
 				break;
 				default:
 				$scope.tag = $scope.verifRegEx(valeur, this.attribut_regex, 
 				this.attribut_min, this.attribut_max, this.attribut_minlength, this.attribut_maxlength); 			}
 		}
 		else {
 			$scope.tag = $scope.verifRegEx(valeur, this.attribut_regex, 
 			this.attribut_min, this.attribut_max, this.attribut_minlength, this.attribut_maxlength);
 		}
 	}

 	// Vérifie qu'un ID existe en table :
 	$scope.checkExistingId = function(suffix, id){
 		switch (suffix){
 			case 'USER' :
				for (var i = 0; i < $scope.dataUser.length; i++) {
				    if (id == $scope.dataUser[i].ID_USER) return true;
				}
 			break;
 			case 'BASE' :
 				for (var i = 0; i < $scope.dataBase.length; i++) {
				    if (id == $scope.dataBase[i].ID_BASE) return true;
				}
 			break;
 			case 'RECET' :
 				for (var i = 0; i < $scope.dataRecette.length; i++) {
				    if (id == $scope.dataRecette[i].ID_RECET) return true;
				}
 			break;
 			case 'ARO' :
 				for (var i = 0; i < $scope.dataArome.length; i++) {
				    if (id == $scope.dataArome[i].ID_ARO) return true;
				}
 			break;
 			default:
 		} 
 	return false ;
 	}

	// Vérifie la saisie, charge le message d'erreur : 	
 	$scope.verifRegEx = function(value, reg, min, max, minlength, maxlength){
 		if (value || value === 0){
 			if (min){
 				if (parseFloat(min) > value) {
 					$scope.msg = "La valeur minimum requise est de " + min;
 					return true;
 				}				
 			}
 			if (max){
 				if (parseFloat(max) < value) {
 					$scope.msg = "La valeur maximum est de " + max;
 					return true;
 				} 				
 			}
 			if (minlength){
 				if (parseFloat(minlength) > value.length) {
 					$scope.msg = "Un minimum de " + minlength + " caractères est requis";
 					return true;
 				}				
 			}
 			if (maxlength){
 				if (parseFloat(maxlength) < value.length) {
 					$scope.msg = "Un maximum de " + maxlength + " caractères est autorisé";
 					return true;
 				} 				
 			}
 			if (reg && !reg.test(value) ){
 				$scope.msg = "La valeur saisie n'est pas conforme";
				return true;
	 		}
	 		else {
	 			$scope.msg = "";
	 			return false;
	 		}
 		}
 		if (!value) $scope.msg = "La saisie d'une valeur est obligatoire";
 		return true;
 	}
 	// Vide les messages d'erreur :
 	$scope.cleanMsg = function(){
		$scope.tag = false;
		$scope.msg = "";
		$scope.msgErrorModif = "";
	 	$scope.tagErrorModif = false;
	 	$scope.msgErrorCrea = [];
		$scope.tagErrorCrea = [];
		$scope.msgConfirm = "";
		$scope.msgInfo = "";
		
		// Vide les valeurs $scope.crea[$index] à la sélection d'une nouvelle table si action = création:
	 	if($scope.choix_table && $scope.choix_table != 9 && $scope.choix_action == 1){
	 		for (var i = 0; i < $scope.dataAdmin[$scope.choix_table].attribut.length; i++){
	 			$scope.crea[i] = "";
	 		}
	 	}
	 	// Si création de recette, ajoute les champ de Parfumer à ceux de Recette (dataAdmin.json) :
	 	if($scope.choix_table && $scope.choix_table == 3 && $scope.choix_action == 1){
	 		if ($scope.dataAdmin[3].attribut.length == 12){
	 			$scope.dataAdmin[3].attribut.push($scope.dataAdmin[8].attribut[1],$scope.dataAdmin[8].attribut[2]);
	 		}
	 	}
	 	else if($scope.dataAdmin[3].attribut.length == 14){
	 			$scope.dataAdmin[3].attribut.pop();
	 			$scope.dataAdmin[3].attribut.pop();
	 	}	 	
 	}
 	// Affectation du message d'erreur (création ou modification) :
 	$scope.setMsgError = function(){
 		if ((this.$index >= 0 )&& this.choix_table && this.choix_action == 1){
 			$scope.msgErrorCrea[this.$index] = $scope.msg;
 			$scope.tagErrorCrea[this.$index] = $scope.tag;
 		}
 		if (this.attribut_modif && this.choix_action == 2){
 			$scope.msgErrorModif = $scope.msg;
 			$scope.tagErrorModif = $scope.tag;
 		}
 	}
	// Envoi du formulaire depuis verif() :
	$scope.postForm = function(){
		if (dataToPost){
	    	$http.post("../controllers/adminController.php", dataToPost)
		 	.then(function (response) {
		 		// console.log(response.data);
		 		$scope.msgForm = response.data;
		 		if ($scope.msgForm === 'success'){
		 			$scope.msgForm = "Votre enregistrement a été effectué";
		 			$scope.msgFormClass = 'success';
		 			$scope.resetFormAdmin();
		 		}
		 		else $scope.msgFormClass = 'danger';
		 	});
	 	}
	};
	// Verification du formulaire :
	$scope.verif = function() {
		if ($scope.choix_action && $scope.choix_table){
			dataToPost = {};
			dataToPost['ACTION'] = $scope.choix_action;
			dataToPost['TABLE'] = $scope.choix_table;
			// Afficher
			if ($scope.choix_action == "0") {
				$scope.msgForm = 'Vous avez sélectionné "Afficher", aucun enregistrement n\'a été réalisé';
				$scope.msgFormClass = 'danger';
			}
			// Créer
			if ($scope.choix_action == "1"){
				var counter = 0;
				var dataRequired = 0;
				for (var i = 0 ; i < $scope.dataAdmin[$scope.choix_table].attribut.length; i++){
					if ($scope.dataAdmin[$scope.choix_table].attribut[i].SHOW == 'true'){
						if ($scope.crea[counter] && $scope.tagErrorCrea[counter] == false){
							dataToPost[$scope.dataAdmin[$scope.choix_table].attribut[i].NAME] = $scope.crea[counter];
							counter ++;
							dataRequired++;
						}
						else {
							if ($scope.tagErrorCrea[counter] == undefined ) {
								$scope.msgErrorCrea[counter] = "Vous devez saisir une valeur";
								$scope.tagErrorCrea[counter] = true;
							}
							counter ++; 
						}
					}
				}
				if (dataRequired === counter) {
					// Si création de recette :
					if ($scope.choix_table == 3) {
						$scope.msgInfo = $scope.verifCalculRecette(dataToPost);
						if (!$scope.msgInfo) 
							 $scope.msgConfirm = "Confirmez-vous la création de cette recette (une entrée sera également créée en table Parfumer) ?";
					}
					// Si création de base :
					if ($scope.choix_table == 7) {
						$scope.msgInfo = $scope.verifCalculBase(dataToPost);
						if (!$scope.msgInfo) 
							 $scope.msgConfirm = "Confirmez-vous la création de cette base ?";
					}
					else $scope.msgConfirm = "Confirmez-vous la création de cette entrée dans la table " + $scope.dataAdmin[$scope.choix_table].label + " ?";
				}
			}
			// Modifier
			if ($scope.choix_action == "2" && $scope.selected_id && $scope.tagIdExist == true){
				if(!$scope.attribut_modif) $scope.tagErrorAttribut = true;
				else {
					if(!$scope.saisie_modif) {
						$scope.tagErrorModif = true;
						$scope.msgErrorModif = "Aucune valeur n'est renseignée";
					}
					else {
						dataToPost['ID_SELECTED'] = ($scope.selected_id).toString();
						dataToPost['ATTRIBUTE'] = $scope.attribut_modif;
						if ($scope.choix_table == 3 && ($scope.attribut_modif == "QTE_ARO"
							|| $scope.attribut_modif == "QTE_BAS" ) ) 
							$scope.msgInfo = "Cette modification va entraîner la mise à jour du dosage de la recette en table 'Parfumer'";
						if ($scope.choix_table == 7 && $scope.attribut_modif == "DOS_PG") 
							$scope.msgInfo = "Le dosage VG de cette base sera également affecté par cette modification";
						if ($scope.choix_table == 7 && $scope.attribut_modif == "DOS_VG") 
							$scope.msgInfo = "Le dosage PG de cette base sera également affecté par cette modification";
						dataToPost[$scope.attribut_modif] = $scope.saisie_modif;
						$scope.msgConfirm = "Confirmez-vous la modification de cette ligne (ID = " +dataToPost['ID_SELECTED']
						+ ") dans la table " + $scope.dataAdmin[$scope.choix_table].label + " ?";
					}
				}
			}
			// Supprimer
			if ($scope.choix_action == "3" && $scope.selected_id && $scope.tagIdExist == true){
				dataToPost['ID_SELECTED'] = ($scope.selected_id).toString();
				// Si suppression en cascade :
				if ($scope.choix_table != 5 && $scope.choix_table != 6)
					$scope.msgInfo = "Attention : si cet ID apparait dans d'autres tables, les entrées concernées seront également supprimées";
				$scope.msgConfirm = "Confirmez-vous la suppression de cette ligne (ID = " +dataToPost['ID_SELECTED']
				+ ") dans la table " + $scope.dataAdmin[$scope.choix_table].label + " ?";
			}
		}
	};
	// Réintialisation du formulaire :
	$scope.resetFormAdmin = function(){
		$scope.formAdmin.$setPristine();
		$scope.formAdmin.$setUntouched();
		$scope.formAdmin.$submitted = false;
		dataToPost = {};
		$scope.choix_action = undefined;
		$scope.choix_table = undefined;
		$scope.selected_id = undefined;
		$scope.attribut_modif = undefined;
		$scope.saisie_modif = undefined;
		$scope.msgConfirm = "";
		$scope.msgInfo = "";
		getAllTables();
	}
	// Vérifications quantités et dosage d'une création de recette :
 	$scope.verifCalculRecette = function($donnees){
 		var res = "";
 		if ($donnees['DOS_ARO'] && $donnees['QTE_ARO']
 			&& $donnees['QTE_BAS'] && $donnees['QTE_TOT']){
 			var dos = parseFloat($donnees['DOS_ARO'].replace(',','.'));
 			var aro = parseFloat($donnees['QTE_ARO'].replace(',','.'));
 			var bas = parseFloat($donnees['QTE_BAS'].replace(',','.'));
 			var tot = parseFloat($donnees['QTE_TOT'].replace(',','.'));
 			if (! (aro + bas == tot) ) return "La quantité totale doit être la somme des quantités 'Arôme' et 'Base'";
 			if (!( aro == tot*(dos/100) )) return "Ce dosage ne correspond pas aux quantités 'Arôme' et 'Base' saisies";
 		}
		return res; // Conforme
 	}
 	// Vérifications des proportions VG/PG d'une création de base :
 	$scope.verifCalculBase = function($donnees){
 		var res = "";
 		if ($donnees['DOS_PG'] && $donnees['DOS_VG']){
 			var pg = parseInt($donnees['DOS_PG']); 
 			var vg = parseInt($donnees['DOS_VG']); 
 			if (pg+vg != 100) return "La somme des dosages VG et PG doit être égale à 100";
 		}
		return res; // Conforme
 	}
});

