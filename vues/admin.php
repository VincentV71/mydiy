<?php
session_start();
require __DIR__ . '/static/bibliotheque.php';

if (!$_SESSION['id']){
	$_SESSION['message']="Vous devez vous connecter pour creer une recette";
	header("Location: connexion.php");
}
else $idUser = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mode Administrateur</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href="static/css/bootstrap.min.css">
    <link rel="stylesheet"  href="static/css/style.css">
  	<!-- ANGULARJS 1.7.7 -->
  	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.7/angular.min.js"></script>
  	<script src="static/js/admin.js"></script>
  </head>

<body ng-app="adminApp" ng-controller ="adminCtrl"> 
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
					<a class="nav-item nav-link" href="new_diy.php">Nouveau DIY</a>
					<a class="nav-item nav-link " href="mes_recettes.php">Mes recettes</a>
					<a class="nav-item nav-link" href="inscription.php">S'inscrire</a>
					<a class="nav-item nav-link " href="connexion.php">Se connecter</a>
				</div>
			</div>
		</div>
	</nav>
<!-- ____________CONTENU___________ -->
<div ng-cloak class="container">
	<div  > 
		<div > 
			<h4 class="spacer">Vous êtes connecté en tant qu'Administrateur</h4>
			<form  name="formAdmin" ng-submit="verif()" novalidate>
				<div class="row justify-content-start spacer"> 
				<!-- ___Choix ACTION -->
					<div class="col-4">
				 		<label for="choix_action">ACTION :</label>
						<select name="choix_action" ng-model="choix_action" id="choix_action" class="form-control form-control-md"  type="text" ng-required="true" ng-change="cleanMsg()" >
							<option value="" >Choisissez une action</option>
							<option  ng-repeat="item in dataAdmin[0].content" value="{{item.ID_ACT}}" >{{item.NOM_ACT}}</option>	
						</select>
						<div ng-show="formAdmin.choix_action.$pristine && formAdmin.$submitted" class="alert alert-warning" role="alert" >Sélectionnez une action</div>
					</div>
						
				<!-- ___Choix TABLE -->
					<div class="col-4">
				 		<label for="choix_table">TABLE :</label>
						<select name="choix_table" ng-model="choix_table" id="choix_table" class="form-control form-control-md"  type="text" ng-required="true" ng-change="checkId(); cleanMsg()" >
							<option  ng-repeat="item in dataAdmin[1].content" value="{{item.ID_TABL}}" >{{item.NOM_TABL}}</option>	
							<option ng-show="choix_action==0" value="9" >Toutes les tables</option>
						</select>
						<div ng-show="formAdmin.choix_table.$pristine && formAdmin.$submitted" class="alert alert-warning" role="alert" >Sélectionnez une table</div>
					</div>

				<!-- ___Choix ID A AFFECTER -->
					<div class="col-4" ng-show="choix_action != 1 && choix_table != 9">
				 		<label for="selected_id">SELECTION ID :</label>
						<input name="selected_id" ng-model="selected_id" id="selected_id" class="form-control form-control-md" type="number" min="1" step="1" ng-required="true" ng-change="checkId()" >
						</input>
						<div ng-show="(selected_id && tagIdExist == false) || (!selected_id && formAdmin.$submitted) " class="alert alert-warning" role="alert" >Entrez un ID valide</div> 
					</div>
				</div> <!-- // Fin Div class row -->
				<hr class="spacer">

			<!-- ___ZONE MODIFICATION -->
				<div class="row justify-content-start spacer form-group row" id="zoneModif" ng-show="choix_action == 2 && selected_id && choix_table != 9">
				<!-- ___Choix ATTRIBUT -->
					<div class="col-4" >
				 		<label for="attribut_modif">CHAMP A MODIFIER :</label>
						<select class="form-control" name="attribut_modif" ng-model="attribut_modif" id="attribut_modif" class="form-control form-control-md"  type="text" ng-required="true" ng-change="setAttribut(attribut_modif); cleanMsg()" >
							<option value="">Choisissez un attribut</option>
							<option  ng-repeat="item in dataAdmin[choix_table].attribut | filter: {SHOW: 'true'} | filter: {NAME: '!QTE_TOT'}" value="{{item.NAME}}" >{{item.LEGEND}}</option>	
						</select>
						<div ng-show="(tagErrorAttribut)||(formAdmin.attribut_modif.$invalid && attribut_modif)" class="alert alert-warning" role="alert" >Choisissez un champ</div>
					</div>

				<!-- ___ATTRIBUT saisie -->
					<div class="col-8" >
						<div >	
							<label for="saisie_modif">SAISISSEZ UNE NOUVELLE VALEUR :</label>					
							<input class="form-control" ng-model="saisie_modif" name="saisie_modif" id="saisie_modif" type="{{attribut_type}}" min="{{attribut_min}}" max="{{attribut_max}}" step="{{attribut_step}}"  ng-change="verifSaisie ( '{{attribut_modif}}', saisie_modif); setMsgError()"  ></input> <!-- ng-required="formAdmin.$submitted" -->
							
							<div ng-show=" tagErrorModif || (attribut_modif && formAdmin.saisie_modif.$dirty && formAdmin.saisie_modif.$invalid)" class="alert alert-warning" role="alert" >{{msgErrorModif}}</div>
						</div>
					</div>
				</div>


			<!-- ___ZONE CREATION -->
				<div  id="zoneCrea" ng-show="choix_action == 1 && choix_table != 9">
					<div ng-repeat="item in dataAdmin[choix_table].attribut | filter: {SHOW: 'true'} track by $index" class="row justify-content-start spacer form-group row">
						
						<div class="col-4" > 
					 		<label for="" class="col-form-label">{{item.LEGEND}}</label>
				 		</div>
					 	<div class="col-8" >
					 		<input class="form-control" ng-model="crea[$index]"  type="'{{item.TYPE}}'"  ng-change="setAttribut('{{item.NAME}}'); verifSaisie('{{item.NAME}}', crea[$index]); setMsgError()"></input>
					 		<div ng-show="(tagErrorCrea[$index] ) ||(formAdmin.crea[$index].$dirty && formAdmin.crea[$index].$invalid)" class="alert alert-warning" role="alert" >{{msgErrorCrea[$index]}}</div>
				 		</div>
					</div>
				</div> <!-- fin zone CREA -->

			<!-- Message d'information si d'autre(s) table(s) seront affectée(s) : -->
				<div ng-show="(msgInfo && (choix_action == 1 || choix_action == 2) && (choix_table == 3 || choix_table == 7) ) || (msgInfo && choix_action == 3)" class="mt-1 mb-1 alert alert-danger role="alert">
					<button ng-click="msgInfo=''" type="button" class="btn btn-outline-danger btn-sm">x </button>
					<span > {{msgInfo}}</span> <!-- id="afficheMsg" -->
				</div>
					
			<!-- Confirmation avant Enregistrement-->	
				<div ng-show="msgConfirm" class="mt-1 mb-1 alert alert-success role="alert">
					<span id="afficheConfirm"> {{msgConfirm}}</span>
					<button ng-click="postForm()" type="button" class="btn btn-outline-success btn-sm">OUI</button>
					<button ng-click="msgConfirm=''" type="button" class="btn btn-outline-success btn-sm">NON</button>
				</div>
			<!-- Enregistrement modifications + message Erreur ou Succès-->	
		 		<div ng-show="msgForm" class="mt-1 mb-1 alert alert-{{msgFormClass}} role="alert">
					<button ng-click="msgForm=''" type="button" class="btn btn-outline-{{msgFormClass}} btn-sm">x </button>
					<span id="afficheMsg"> {{msgForm}}</span>
				</div>
		 		<button type="submit" class="btn btn-outline-primary btn-lg btn-block spacer" >Enregistrer</button>

		 <!-- Affichage des tables -->
				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 2 "> 
		 			<span><h5>Table USER</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[2].attribut">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataUser | orderBy:'ID_USER' | filter: {ID_USER: selected_id} :true">
					      <th scope="row" >{{x.ID_USER}}</th>
					      <td scope="row" >{{x.NOM_USER}}</td>
					      <td scope="row" >{{x.MAIL_USER}}</td>
					      <td scope="row" >{{x.AFF_USER}}</td>
					      <td scope="row" >{{x.PASSWD}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>

				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 3 "> 
		 			<span><h5>Table RECETTE</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[3].attribut | filter: {NAME: '!ID_ARO'} | filter: {NAME: '!DOS_ARO'}">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataRecette | orderBy:'ID_RECET' | filter: {ID_RECET: selected_id} :true "> <!-- filter: {NAME: '!ID_ARO'} -->
					      <th scope="row" >{{x.ID_RECET}}</th>
					      <td scope="row" >{{x.ID_USER}}</td>
					      <td scope="row" >{{x.ID_BASE}}</td>
					      <td scope="row" >{{x.DAT_RECET}}</td>
					      <td scope="row" >{{x.QTE_ARO}}</td>
					      <td scope="row" >{{x.QTE_BAS}}</td>
					      <td scope="row" >{{x.QTE_TOT}}</td>
					      <td scope="row" >{{x.DAT_STEE}}</td>
					      <td scope="row" >{{x.ETA_STEE}}</td>
					      <td scope="row" >{{x.COM_USER}}</td>
					      <td scope="row" >{{x.AFF_RECET}}</td>
					      <td scope="row" >{{x.ETOILES}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>

				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 4 "> 
		 			<span><h5>Table AROME</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[4].attribut">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataArome | orderBy:'ID_ARO' | filter: {ID_ARO: selected_id} :true" >
					      <th scope="row" >{{x.ID_ARO}}</th>
					      <td scope="row" >{{x.NOM_ARO}}</td>
					      <td scope="row" >{{x.FAB_ARO}}</td>
					      <td scope="row" >{{x.DOS_FAB}}</td>
					      <td scope="row" >{{x.NB_J_STEE}}</td>
					      <td scope="row" >{{x.CAT_ARO}}</td>
					      <td scope="row" >{{x.AFF_ARO}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>

				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 5 "> 
		 			<span><h5>Table PRIX</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[5].attribut">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataPrix | orderBy:'ID_PRIX' | filter: {ID_PRIX: selected_id} :true">
					      <th scope="row" >{{x.ID_PRIX}}</th>
					      <td scope="row" >{{x.ID_ARO}}</td>
					      <td scope="row" >{{x.PRIX}}</td>
					      <td scope="row" >{{x.QTE_BTLLE}}</td>
					      <td scope="row" >{{x.FOURNIS}}</td>
					      <td scope="row" >{{x.E_COM}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>

				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 6 "> 
		 			<span><h5>Table AVIS</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[6].attribut">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataAvis | orderBy:'ID_AVIS'| filter: {ID_AVIS: selected_id} :true">
					      <th scope="row" >{{x.ID_AVIS}}</th>
					      <td scope="row" >{{x.ID_USER}}</td>
					      <td scope="row" >{{x.ID_RECET}}</td>
					      <td scope="row" >{{x.TEXT_AVI}}</td>
					      <td scope="row" >{{x.NOTE_AVI}}</td>
					      <td scope="row" >{{x.DATE_AVI}}</td>
					      <td scope="row" >{{x.AFF_AVI}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>

				<div class="table-responsive" ng-hide="choix_table && choix_table != 9 && choix_table != 7 "> 
		 			<span><h5>Table BASE</h5></span>
			 		<table class="table table-hover table-sm">
					  <thead>
					    <tr scope="col" >
					      <th ng-repeat="item in dataAdmin[7].attribut">{{item.LEGEND}} </th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr ng-repeat="x in dataBase | orderBy:'ID_BASE'  | filter: {ID_BASE: selected_id} :true">
					      <th scope="row" >{{x.ID_BASE}}</th>
					      <td scope="row" >{{x.DOS_PG}}</td>
					      <td scope="row" >{{x.DOS_VG}}</td>
					      <td scope="row" >{{x.CORRECTIF}}</td>
					    </tr>
					  </tbody>
					</table>
				</div>				
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