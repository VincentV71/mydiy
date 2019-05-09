<?php
session_start();
require __DIR__ . '/static/bibliotheque.php';
 
if (!$_SESSION['id']){
	$_SESSION['message']="Vous devez vous connecter pour creer une recette";
	header("Location: connexion.php");
}
else {
	$idUser = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Créer un nouveau Diy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href="static/css/bootstrap.min.css">
    <link rel="stylesheet"  href="static/css/style.css">
  	<!-- ANGULARJS 1.7.7 -->
  	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.7/angular.min.js"></script>
  	<script src="static/js/new_diy.js"></script>
  </head>

<body ng-app="newDiy" ng-controller ="newDiyCtrl"> 
	<nav class="navbar navbar-toggleable-sm navbar-light navbar-inverse" style="">
		<!-- Container pour limiter la largeur LOGO + Item Menu -->	
		<div class="container" role="navigation"> 
			<a class="navbar-brand justify-content-start hidden-sm-down" href="../index.php">
	    	<img src="static/img/logo-noir.png" id="#logoNav" width="80" height="80" role="navigation" ></a>
			<!-- Toggler qui se déplie et qui prend diyNav-->
			<button class="navbar-toggler navbar-toggler mt-3" type="button" data-toggle="collapse" data-target="#diyNav" aria-controls="diyNav" aria-expanded="false" aria-label="Toggle navigation">
				<!-- sous forme de Burger -->	
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- Source du Toggler : -->
			<div id="diyNav" class="collapse navbar-collapse justify-content-end">
				<div class="navbar-nav text-uppercase ">
					<a class="nav-item nav-link " href="../index.php">Accueil</a>
					<a class="nav-item nav-link active" href="new_diy.php">Nouveau DIY</a>
					<a class="nav-item nav-link " href="mes_recettes.php">Mes recettes</a>
					<a class="nav-item nav-link" href="inscription.php">S'inscrire</a>
					<a class="nav-item nav-link " href="connexion.php">Se connecter</a>
				</div>
			</div>
		</div>
	</nav>
	<!-- CONTENU-->
	<div ng-cloak class="container">
		<div  > <!-- mt-3 pl-3   style="padding-left: 15px;"  class="row lg-12"-->
			<div > <!-- justify-content-start spacer -->
				<form  name="formRecette" ng-submit="verif()" novalidate>


					<div class="row justify-content-start spacer"> 
						<div class="col-6">
							<!-- Choix de l'AROME -->
					 		<label for="choix_arome">AROME :</label>
							<select name="choix_arome" id="choix_arome" class="form-control form-control-sm" ng-model="aro" type="text" ng-required="true" ng-change="aromeCheck(); calculRecette()" >
								<option  value="" >Choisissez votre arôme</option>
								<option  ng-repeat="item in dataArome" value="{{item.ID_ARO}}" >{{item.NOM_ARO}} - {{item.FAB_ARO | uppercase}}</option>	
							</select>
							<div ng-show="verifAro() || formRecette.choix_arome.$pristine && formRecette.$submitted" class="alert alert-warning" role="alert" >Sélectionnez un arôme pour composer votre recette</div>
						</div>
							
							<!-- DOSAGE -->
						<div class="col-6  ">  <!-- offset-lg-1 -->
							<label for="choix_dosage">DOSAGE :</label>
							<div>						
								<input ng-model="dos" name="choix_dosage" id="choix_dosage" type="number" min="1" max="50" step="0.1" ng-change="calculRecette()" ng-required="true" ></input>
								<label for="choix_dosage">%</label>
								<div ng-show="verifDos() && (formRecette.choix_dosage.$dirty || formRecette.$submitted)" class="alert alert-warning" role="alert" >Sélectionnez une valeur entre 1 et 50% (1 décimale max.)</div>
							</div>	
						</div>
					</div> <!-- // Fin Div class row -->
					<hr class="spacer">
							
						<!-- Choix de la BASE -->
						<div class="progress-box" >
						  <div class="percentage-cur" > 
						  	<label for="choix_base">TYPE DE BASE :</label>
						    <span ng-cloak class="num" ng-required="true" > {{ pgChoice }} % PG / {{ 100-pgChoice }} % VG </div>
						  </span>
						  <div class="progress-bar progress-bar-slider" >
						    <input name="choix_base" ng-model="pgChoice" ng-change= "pgCheck(); calculRecette()" class="progress-slider" type="range" min="0" max="100" step="10">
						    <div class="inner" ng-style="{ width: pgChoice + '%' || '0%' }"></div>
						  </div>
						</div>
						<hr class="spacer" id="hr_spacer" >

					<!-- Choix Quantité totale à réaliser -->
					<div>
						<label for="total_recette">QUANTITE TOTALE DESIREE :</label>
						<input ng-model="totalQte" ng-change="calculRecette()" type="number" name="total_recette" id="total_recette" min="5" max="1000" step="1" ng-required="true"> ml</input>
						<div ng-show="verifQte() && formRecette.total_recette.$invalid && (formRecette.total_recette.$dirty || formRecette.$submitted)" class="alert alert-warning" role="alert" >Saisissez une quantité entre 5 et 1000 ml (nombres décimaux exclus)</div>
					</div>

					<!-- composition de la recette -->
					<hr class="spacer" >
					<div id="rctContainer" >
			 			<div class="row" id="spacerRecet" >
				 			<div class="col-6 d-flex justify-content-center font-weight-light " >
				 				<div ><h1>{{baseQte}} </h1></div>
				 			</div>
				 			<div class="col-6 d-flex justify-content-center font-weight-light">
				 				<span><h1>{{aroQte}}</h1></span>
				 			</div>
			 			</div>
			 			<div class="row mt-1">
				 			<div class="col-6 d-flex justify-content-center " >
				 				<div >ml de BASE</div>
				 			</div>
				 			<div class="col-6 d-flex justify-content-center ">
				 				<span>ml d'AROME</span>
				 			</div>
			 			</div>
			 			<div class="row spacer mt-5">
				 			<div class="col-6 d-flex justify-content-center font-weight-light" >
				 				<div ><h1>{{steep_prevu}} </h1></div>
				 			</div>
				 			<div class="col-6 d-flex justify-content-center font-weight-light">
				 				<span><h1>{{steep_pret}}</h1></span>
				 			</div>
			 			</div>
			 			<div class="row mt-1 ">
				 			<div class="col-6 d-flex justify-content-center" >
				 				<div >jours de Steep</div>
				 			</div>
				 			<div class="col-6 d-flex justify-content-center">
				 				<span>Date de fin de steep</span>
				 			</div>
			 			</div>
			 		</div>

			 		<div ng-show="msg" class="mt-1 mb-1 alert alert-{{msgClass}} role="alert">
						<button ng-click="msg=''" type="button" class="btn btn-outline-{{msgClass}} btn-sm">x </button>
						<span id="afficheMsg"> {{msg}}</span>
					</div>
			 		<button type="submit" class="btn btn-outline-primary btn-lg btn-block spacer">Sauvegarder cette recette</button>
			 	</form>
		 	</div>
		</div>
		<hr>
	</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="static/js/jquery-3.1.1.slim.min.js"  type="text/javascript"></script>
    <script src="static/js/tether.min.js"  type="text/javascript"></script>
    <script src="static/js/bootstrap.min.js"  type="text/javascript"></script>
  </body>
</html>