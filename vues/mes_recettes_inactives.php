<?php  
session_start();
require __DIR__ . '/static/bibliotheque.php';
require __DIR__ . '../../model/managers/Manager.php';
require __DIR__ . '../../model/managers/RecetteManager.php';

// Test si un user s'est connecté :
if (!$_SESSION['id']){
	$_SESSION['message']="Vous devez vous connecter pour accEder A vos recettes";
	header("Location: connexion.php");
}
$idUser = $_SESSION['id'];

// test si affichage par défaut ou personnalisé
$order = "dat_recet DESC";	
if ( isset($_POST["tri_recette"]) )	$order = $_POST["tri_recette"];

$aff = "non";

$myRecetteManager = new RecetteManager;
$resRecetOff = $myRecetteManager->getAllRecetUser($idUser, $aff, $order);	
// Nb de recettes inactives de l'utilisateur :
 $nbRecetOff = $resRecetOff->rowCount();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Réactiver une recette</title>
  <!-- Bootstrap CSS -->
  <link href="https://fonts.googleapis.com/css?family=Saira+Condensed:800" rel="stylesheet">
  <link rel="stylesheet" href="static/css/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
  <nav class="navbar navbar-toggleable-sm navbar-light navbar-inverse" style="">
    <!-- Container pour limiter la largeur LOGO + Item Menu -->
    <div class="container" role="navigation">
      <!-- = container FIXED -->
      <a class="navbar-brand justify-content-start hidden-sm-down" href="../index.php">
        <img src="static/img/logo-noir.png" id="#logoNav" width="80" height="80" role="navigation"></a>
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
          <a class="nav-item nav-link active" href="mes_recettes.php">Mes recettes</a>
          <a class="nav-item nav-link" href="inscription.php">S'inscrire</a>
          <a class="nav-item nav-link " href="connexion.php">Se connecter</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- CONTENU -->
  <div class="container p-0">
    <div class="row mt-3 mb-3 pl-4">
      <medium class="text pl-2">Vous avez <strong><?php echo ($nbRecetOff); ?></strong>
        <?php echo nbInactive($nbRecetOff); ?>
      </medium>
      <br>
    </div>
    <hr>
    <!-- TRI -->
    <div class="row mt-3 pl-3">
      <div class="justify-content-start">
        <form action="mes_recettes_inactives.php" method="POST">
          <label for="tri_recette">Trier les recettes par :</label>
          <select name="tri_recette">
            <option value="DAT_RECET ASC">date de création (croissante)</option>
            <option value="DAT_RECET DESC">date de création (décroissante)</option>
            <option value="DAT_STEE ASC">date de steep (croissante)</option>
            <option value="DAT_STEE DESC">date de steep (décroissante)</option>
            <option value="NOM_ARO">arôme</option>
            <option value="FAB_ARO">fabricant</option>
            <option value="ETA_STEE">état du steep</option>
            <option value="ETOILES DESC">notation étoiles</option>
            <option value="DOS_ARO">dosage</option>
            <option value="BASE.ID_BASE">type de base</option>
          </select>
          <input type="submit" class="btn btn-secondary btn-sm" />
        </form>
      </div>
    </div>
    <hr>

    <div class="container-fluid p-0">
      <div class="row">
        <!-- Affichage des recettes -->
        <?php while ($donnees=$resRecetOff->fetch()) { $donnees = formateFloat($donnees); ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 ">
          <div class="card pt-1 <?php echo (strtolower($donnees['AFF_RECET'])); ?>">
            <div class="cartouche">
              <strong>
		  		<?php echo ($donnees['ETA_STEE']); ?>
		  		</strong>
              <h3 class="mt-3 text-uppercase"><strong><?php echo $donnees['NOM_ARO']; ?></strong></h3>
              <h5 class="text-uppercase"><em><?php echo $donnees['FAB_ARO']; ?></em></h5>
              <p class="pb-2"><strong><?php echo $donnees['DOS_ARO']; ?> %</strong></p>
            </div>
            <div class="card-block">
              <p><em><?php echo $donnees['COM_USER']; ?></em></p>
              <div class="badge badge-pill badge-default mb-1 pt-1">Base
                <?php echo $donnees[ 'DOS_PG']; ?> /
                <?php echo $donnees[ 'DOS_VG']; ?>
              </div>
              <span class="badge badge-pill badge-default"><?php echo $donnees['QTE_BAS']; ?> ml (base) + <?php echo $donnees['QTE_ARO']; ?> ml (arôme)</span>
              <span class="badge badge-pill badge-default mb-3">Qté totale : <?php echo $donnees['QTE_TOT']; ?> ml</span>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><span>
		    	<li class="list-group-item"><span >
				<?php 
				$etoiles = $donnees['ETOILES'];
				if ($etoiles==0) {
					?>
					<img src="static/img/star_outline_36px.png" width="28" height="28"><img src="static/img/star_outline_36px.png" width="28" height="28"><img src="static/img/star_outline_36px.png" width="28" height="28"><img src="static/img/star_outline_36px.png" width="28" height="28"><img src="static/img/star_outline_36px.png" width="28" height="28">
					<?php
				} 
				else {
					for ($i=0; $i < ($etoiles); $i++){
						?> 
						<img src="static/img/star_36px.png" width="28" height="28">
						<?php 
					}
					$i++;
					for ($i; $i<=5; $i++){
						?> 
						<img src="static/img/star_outline_36px.png" width="28" height="28">
						<?php 
					} 
				}
				?> 
				</span></li>
                <li class="list-group-item">Date création :
                  <?php echo $donnees[ 'DAT_RECET']; ?>
                </li>
                <li class="list-group-item">Steep estim. :
                  <?php echo $donnees[ 'DAT_STEE']; ?>
                </li>
              </ul>

              <div class="mt-3">
                <!-- _REACTIVER une RECETTE-->
                <form action="../controllers/mes_recettesController.php" method="POST">
                  <input name="ID_RECET" type="hidden" value="<?php echo ($donnees['ID_RECET']); ?>">
                  <button type="submit" class="btn btn-secondary w-100" name="AFF_RECET" value='oui'>Réactiver cette recette</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div> <!--fin de Div ROW (hors du FETCH)-->
    </div>
  </div> <!-- Fin Div Container PRINCIPAL -->

  <!-- jQuery first, then Tether, then Bootstrap JS. -->
  <script src="static/js/jquery-3.1.1.slim.min.js" type="text/javascript"></script>
  <script src="static/js/tether.min.js" type="text/javascript"></script>
  <script src="static/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>