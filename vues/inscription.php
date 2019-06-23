<?php
session_start();
require __DIR__ . '/static/bibliotheque.php';
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>S'inscrire</title>

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
					<a class="nav-item nav-link active" href="inscription.php">S'inscrire</a>
					<a class="nav-item nav-link" href="connexion.php">Se connecter</a>
				</div>
			</div>
		</div>
	</nav>

	<!-- CONTENU -->
	<div class="jumbotron Jumbotron-fluid justify-content-center">	
		<div class="container">
			<!-- message d'erreur -->
			<?php if ( isset($_SESSION['inscriptionMsg']) && !is_null($_SESSION['inscriptionMsg']) ) { 
			 ?>
				<div class="justify-content-center alert alert-<?php echo $_SESSION['classMsg']; ?>" role="alert">
					<form action="inscription.php" method="POST" >
						<input type="submit" class="btn btn-outline-<?php echo $_SESSION['classMsg']; ?> btn-sm" value="X"/>
						<p class="showMessage"><?php echo $_SESSION['inscriptionMsg']; ?></p>
						<?php unset($_SESSION['inscriptionMsg']); 
						unset($_SESSION['classMsg']); ?>
					</form>
				</div>
			<?php } ?>
			<form action="../controllers/authentifController.php" method="POST" class="form-control-sm">
				<div class="form-group row">
					<label for="pseudo" class="col-sm-4 col-form-label text-left"><h5>Entrez votre pseudo :</h5></label>
						<div class="col-sm-8">
							<input name="pseudo" type="text" class="form-control" id="pseudo" required>
						</div>
				</div>

				<div class="form-group row">
					<label for="pass" class="col-sm-4 col-form-label text-left"><h5>Entrez votre mot de passe : </h5></label>
						<div class="col-sm-8">
							<input name="pass" type="password" class="form-control" id="pass" required>
						</div>
				</div>

				<div class="form-group row">
					<label for="confpass" class="col-sm-4 col-form-label text-left"><h5>Confirmez votre mot de passe : </h5></label>
						<div class="col-sm-8">
							<input name="confpass" type="password" class="form-control" id="confpass" required>
						</div>
				</div>

				<div class="form-group row">
					<label for="mail" class="col-sm-4 col-form-label text-left"><h5>Entrez votre email : </h5></label>
						<div class="col-sm-8">
							<input name="mail" type="email" class="form-control" id="mail" required>
						</div>
				</div>
				
				<div class="row justify-content-center">
					<input type="submit" name="forminscription" value="S'inscrire" class="btn btn-secondary btn-lg" />
					<input type="reset" name="reinitialiser" value="Réinitialiser" class=" btn btn-secondary btn-md offset-sm-1" />
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
