var monApp = angular.module('newDiy', []);
monApp.controller('newDiyCtrl', function($scope, $http) {

	// Récupère les tables "Arome" et "Base" en json :
	$http.get("../model/json/getJson.php?table=Arome")
	 .then(function (response) {
	 	$scope.dataArome = response.data;
	 });

	 $http.get("../model/json/getJson.php?table=Base")
	 .then(function (retour) {
	 	$scope.dataBase = retour.data;
	 });

	 // Déclaration des variables nécessaires aux calculs :
	 var idSelect, idBaseSelect, baseCorrectif, resDosage, nbJdeSteep;
	 $scope.creaRecette = new Date().toLocaleDateString();
	 if (!idBaseSelect){
	 	idBaseSelect = 6;
	 	$scope.pgChoice= 50;
	 }

	// Envoi du formulaire depuis verif() :
	$scope.postForm = function(){
	    var data = {
	    	'ID_USER' : "",
	    	'ID_BASE' : idBaseSelect,
	        'DAT_RECET' : $scope.creaRecette,
	        'QTE_ARO' : $scope.aroQte,
	        'QTE_BAS' : $scope.baseQte,
	        'QTE_TOT' : $scope.totalQte,
	        'DAT_STEE' : $scope.steep_pret,
	        'ID_ARO' : $scope.aro,
	        'DOS_ARO' : $scope.dos
	    };

	    $http.post("../controllers/new_DiyController.php", data)
		 	.then(function (response) {
		 		console.log(response.data);
		 		$scope.msg = response.data;
		 		if ($scope.msg === 'success'){
		 			$scope.msg = "Votre recette est désormais enregistrée";
		 			$scope.msgClass = 'success';
		 		}
		 		else $scope.msgClass = 'danger';
		 		$scope.resetForm();
		 	});
	};

	// Verification du formulaire :
	$scope.verif = function() {
		if ($scope.aro && $scope.dos && $scope.totalQte && idBaseSelect
			&& $scope.creaRecette && $scope.aroQte && $scope.baseQte
			&& $scope.steep_pret && $scope.steep_prevu){
			console.log ("le formulaire est OK");
			$scope.postForm();
		}
		else {
			$scope.msg = "Votre recette n'a pas été enregistrée";
			$scope.msgClass = 'danger';
		}
	};

	$scope.verifAro = function(){
		// Choix arôme
		if (!$scope.aro && $scope.dos && $scope.totalQte){
			return true;
		}
		else return false;
	};

	$scope.verifDos = function(){
		// % d'arome
		if (!$scope.dos){
			return true;
		}
		if ($scope.dos && formRecette.choix_dosage.$dirty){
			if ($scope.dos < 1 || $scope.dos > 50){
				return true;
			}
		}
		else return false;
	};

	$scope.verifQte = function() {
		// quantité totale
		if (!$scope.totalQte ){
			return true;
		}
		if ($scope.totalQte && formRecette.total_recette.$dirty){
			if ($scope.totalQte < 5 || $scope.totalQte > 1000){
				return true;
			}
		}
		else return false;
	};
	// Réintialisation du formulaire :
	$scope.resetForm = function(){
		$scope.formRecette.$setPristine();
		$scope.formRecette.$setUntouched();
		formRecette.$submitted = false;
		$scope.aro= undefined;
		$scope.dos= undefined ;
		$scope.totalQte= undefined;	
		$scope.baseQte= undefined;
		$scope.aroQte= undefined ;
		$scope.steep_pret= undefined;
		$scope.steep_prevu= undefined ;
		idBaseSelect = 6;
	 	$scope.pgChoice= 50;
	}
	
 	// ID de l'arôme > Hydrate Dosage Fabricant + reinitialise base à 50/50:
 	$scope.aromeCheck = function(){
 		idSelect = $scope.aro ;
 		for (var i = 0; i < $scope.dataArome.length; i++) {
		    if ( idSelect == $scope.dataArome[i].ID_ARO) {
		    	resDosage = $scope.dataArome[i].DOS_FAB ;
		    	nbJdeSteep =  $scope.dataArome[i].NB_J_STEE;
		    }
		}
		$scope.dos = parseFloat(resDosage);
 	} 

 	// Choix PG > renseigne l'id de la base sélectionnée
 	// et applique le correctif sur $scope.dos  :
 	$scope.pgCheck = function(){
 		var pgSelect = $scope.pgChoice ;
 		for (var i = 0; i < $scope.dataBase.length; i++) {
		    if ( pgSelect == $scope.dataBase[i].DOS_PG) {
		    	idBaseSelect = parseInt($scope.dataBase[i].ID_BASE, 10) ;
		    	baseCorrectif = parseFloat($scope.dataBase[i].CORRECTIF) ; 
		    }
		}
		// applique le correctif SI un arôme est choisi:
		if ($scope.aro){
			$scope.dos = (Math.round(baseCorrectif*resDosage*10) )/10;
		}
 	} 

 	// Calcul de la recette (arome, puis base)
 	$scope.calculRecette = function(){
 		if (this.aro && this.dos && this.pgChoice && this.totalQte){
 			this.aroQte = this.totalQte * (this.dos/100);
 			this.aroQte = (Math.round(this.aroQte*10) )/10;
 			this.baseQte = this.totalQte - this.aroQte;
 			// calcul STEEP
 			this.steep_prevu = nbJdeSteep;

 			// Obtiens la date actuelle, convertit en millisecondes, puis ajoute NbjourSteep X 86400000 ms/jour. 
 			// Pour hydrater this.steep_pret. Nouvel Objet Date d'après la nouvelle valeur, conversion en LocaleSTRING
 			var prevu = new Date().getTime() + (86400000 * nbJdeSteep);
 			this.steep_pret = new Date(prevu).toLocaleDateString();
 		}
 	}
});

