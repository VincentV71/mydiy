<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no">
    <title>MyDiy est une application qui vous aide à gérer vos recettes de e-liquide : dosage "Do-It-Yourself" (arôme, base, temps de steep), archivage de recettes avec notation, commentaires, etc...</title>
    <link rel="stylesheet"  href="vues/static/css/bootstrap.min.css">
    <link rel="stylesheet"  href="vues/static/css/style.css">
  </head>

  <body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-toggleable-sm navbar-light navbar-inverse" style="">
		<!-- Container pour limiter la largeur LOGO + Item Menu -->	
		<div class="container" role="navigation"> <!-- = container FIXED -->
			<a class="navbar-brand justify-content-start hidden-sm-down" href="index.php">
	    	<img src="vues/static/img/logo-noir.png" id="#logoNav" width="80" height="80" role="navigation" ></a>
			<!-- Toggler qui se déplie et qui prend diyNav-->
			<button class="navbar-toggler navbar-toggler mt-3" type="button" data-toggle="collapse" data-target="#diyNav" aria-controls="diyNav" aria-expanded="false" aria-label="Toggle navigation">
				<!-- icon type Burger -->	
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- Source du Toggler : -->
			<div id="diyNav" class="collapse navbar-collapse justify-content-end">
				<div class="navbar-nav text-uppercase ">
					<a class="nav-item nav-link active" href="index.php">Accueil</a>
					<a class="nav-item nav-link" href="vues/new_diy.php">Nouveau DIY</a>
					<a class="nav-item nav-link" href="vues/mes_recettes.php">Mes recettes</a>
					<a class="nav-item nav-link" href="vues/inscription.php">S'inscrire</a>
					<a class="nav-item nav-link" href="vues/connexion.php">Se connecter</a>
				</div>
			</div>
		</div>
	</nav>

	<!-- CONTAINER pour le contenu :-->	
	<div class="jumbotron jumbotron-fluid text-center" >	
		<div class="container">
			<h1 class="display-3">E-liquide maker</h1>
			<p class="lead ml-5 mr-5">MyDiy est un outil de gestion qui facilitera votre quotidien de Diyeur : vous pourrez calculer facilement les dosages de vos Diy grâce à nos fonctions, archiver et consulter vos recettes et leur avancement (steep), les commenter, les noter...  </p>
			<div class="row justify-content-center">
				<div class="col-md-4 col-lg-3 col-xl-3 mt-3">
					<a href="vues/inscription.php" >
						<button type="button" class="btn btn-light btn-lg btn-block" action="vues/inscription.php">Je m'inscris</button>
					</a>
				</div>	
				<br>
				<div class="col-md-4 col-lg-3 col-xl-3 mt-3">
					 <a href="vues/connexion.php"  > 
						<button type="button" class="btn btn-light btn-lg btn-block" action="vues/connexion.php" >Je me connecte</button>
					</a>
				</div>
			</div>
		</div>
	</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="vues/static/js/jquery-3.1.1.slim.min.js"  type="text/javascript"></script>
    <script src="vues/static/js/tether.min.js"  type="text/javascript"></script>
    <script src="vues/static/js/bootstrap.min.js"  type="text/javascript"></script>
  </body>
</html>

