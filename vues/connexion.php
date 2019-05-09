<?php
session_start();
require __DIR__ . '/static/bibliotheque.php';
?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Se connecter</title>
	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href="static/css/bootstrap.min.css">
    <link rel="stylesheet"  href="static/css/style.css">
  </head>

  <body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-toggleable-sm navbar-light navbar-inverse" style="">
		<!-- Container pour limiter la largeur LOGO + Item Menu -->	
		<div class="container" role="navigation"> <!-- = container FIXED -->
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
					<a class="nav-item nav-link" href="mes_recettes.php">Mes recettes</a>
					<a class="nav-item nav-link" href="inscription.php">S'inscrire</a>
					<a class="nav-item nav-link active" href="connexion.php">Se connecter</a>
				</div>
			</div>
		</div>
	</nav>

	<!-- CONTAINER pour le contenu sous la NAV BAR-->	
	<div class="jumbotron Jumbotron-fluid justify-content-center">	
		<div class="container">
			<!-- message d'erreur -->
			<?php if ( isset($_SESSION['connexionMsg']) && !is_null($_SESSION['connexionMsg']) ) { 
			 ?>
				<div class="justify-content-start alert alert-danger" role="alert">
					<form action="connexion.php" method="POST" >
						<input type="submit" class="btn btn-outline-danger btn-sm" value="X"/>
						<p class="showMessage"><?php echo $_SESSION['connexionMsg']; ?></p>
						<?php unset($_SESSION['connexionMsg']); ?>
						
					</form>
				</div>
			<?php } ?>
			<form action="../controllers/authentifController.php" method="POST"  class="form-control-sm">
				<div class="form-group row">
					<label for="inputEmail" class="col-sm-2 col-form-label text-left"><h5>Email</h5></label>
						<div class="col-sm-10">
							<input name="mailconnect" type="email" class="form-control" id="inputEmail" placeholder="Email">
						</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label text-left"><h5>Password</h5></label>
						<div class="col-sm-10">
							<input name="mdpconnect" type="password" class="form-control" id="inputPassword" placeholder="Password">
						</div>
				</div>
				<div class="row justify-content-center">
					<button type="submit" name="formconnexion" value="Se connecter" class="btn btn-light btn-lg btn-block justify-content-center col-md-4 col-lg-3 col-xl-3 mt-3 mb-3">Se connecter</button>
				</div>
			</form>
		</div> <!-- Class CONTAINER -->
	</div> <!-- Jumbotron -->

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="static/js/jquery-3.1.1.slim.min.js"  type="text/javascript"></script>
    <script src="static/js/tether.min.js"  type="text/javascript"></script>
    <script src="static/js/bootstrap.min.js"  type="text/javascript"></script>
  </body>
</html>

