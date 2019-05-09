<?php  
session_start();
require __DIR__ . '/static/bibliotheque.php';
require __DIR__ . '../../model/managers/Manager.php';
require __DIR__ . '../../model/managers/RecetteManager.php';

// Test si un user s'est connecté :
if (!$_SESSION['id']){
	$_SESSION['connexionMsg'] = "Vous devez vous reconnecter";
    $_SESSION['classMsg'] = "danger";	
    header("Location: connexion.php");
}
$idUser = $_SESSION['id'];

// Affichage par défaut ou trié :
$order = "dat_recet DESC";	
if ( isset($_POST["tri_recette"]) ){
	$order = $_POST["tri_recette"];
}
$aff = "oui";
$myRecetteManager = new RecetteManager;
$resRecetOn = $myRecetteManager->getAllRecetUser($idUser, $aff, $order);
// Nb de recettes actives de l'utilisateur :
$nbRecetOn = $resRecetOn->rowCount();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mes recettes</title>
  <link href="https://fonts.googleapis.com/css?family=Saira+Condensed:800" rel="stylesheet">
  <link rel="stylesheet" href="static/css/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
  <!-- NAVBAR -->
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
  <div class="container">
    <div class="row mt-3 pl-3">
      <medium class="text mr-5 mb-2">Bienvenue <strong><?php echo ($_SESSION['nom']); ?></strong>, vous avez <strong><?php echo ($nbRecetOn); ?></strong>
        <?php echo nbActive($nbRecetOn); ?>
      </medium>
      <br>
      <!-- REACTIVER une RECETTE -->
      <!--Bouton Réactiver une recette -->
      <div class="justify-content-end">
        <form action="../controllers/mes_recettesController.php" method="POST">
          <input type="submit" class="btn btn-secondary btn-sm " name="reveil_recette" value="REACTIVER UNE RECETTE" />
        </form>
      </div>
    </div>
    <hr>
    <!-- message d'erreur -->
    <?php if ( isset($_SESSION[ 'mes_recettesError']) && !is_null($_SESSION[ 'mes_recettesError']) ) { ?>
    <div class="justify-content-start alert alert-danger" role="alert">
      <form action="mes_recettes.php" method="POST">
        <p>
          <?php echo $_SESSION[ 'mes_recettesError']; ?>
        </p>
        <?php unset($_SESSION[ 'mes_recettesError']); ?>
        <input type="submit" class="btn btn-outline-danger btn-sm" value="OK" />
      </form>
    </div>
    <?php } ?>
    <!-- TRI -->
    <div class="row mt-3 pl-3">
      <div class="justify-content-start">
        <form action="mes_recettes.php" method="POST">
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
    <!-- AFFICHAGE des Recettes-->
    <div class="container-fluid p-0">
      <div class="row">
        <?php while ($donnees=$resRecetOn->fetch()) { $donnees = formateFloat($donnees); ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 ">
          <div class="card pt-1 <?php echo (strtolower($donnees['ETA_STEE'])); ?>">
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

              <!--DropUp menu PRIMAIRE-->
              <div class="dropup mt-3">
                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Modifier
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#deplieEtoiles<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieEtoiles<?php echo ($donnees['ID_RECET']); ?>">Noter</button>

                  <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#deplieCommentaires<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieCommentaires<?php echo ($donnees['ID_RECET']); ?>">Commenter</button>

                  <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#deplieSteep<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieSteep<?php echo ($donnees['ID_RECET']); ?>">Modifier l'état du steep</button>

                  <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#deplieSupprimer<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieSupprimer<?php echo ($donnees['ID_RECET']); ?>">Supprimer</button>
                </div>
              </div>
              <!--fin du Dropdown menu PRIMAIRE-->

              <!--SHOW/HIDDEN pour les ETOILES-->
              <div class="collapse mt-2" id="deplieEtoiles<?php echo ($donnees['ID_RECET']); ?>">
                <div class="row">
                  <form action="../controllers/mes_recettesController.php" method="POST">
                    <!-- Bouton HIDDEN : récupération du N° de la recette -->
                    <input name="ID_RECET" type="hidden" value="<?php echo ($donnees['ID_RECET']); ?>">
                    <!-- Nouvelle Notation : ETOILES; (A faire en SHOW/HIDE) -->
                    <label for="ETOILES">Entrez votre note (de 0 à 5) :</label>
                    <select name="ETOILES">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <input type="submit" />
                  </form>
                  <button class="btn btn-secondary btn-md mt-2" type="button" data-toggle="collapse" data-target="#deplieEtoiles<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieEtoiles<?php echo ($donnees['ID_RECET']); ?>">X</button>
                </div>
              </div>
              <!--FIN du SHOW/HIDDEN pour les ETOILES-->

              <!--SHOW/HIDDEN pour les COMMENTAIRES-->
              <div class="collapse mt-2" id="deplieCommentaires<?php echo ($donnees['ID_RECET']); ?>">
                <div class="row">
                  <form action="../controllers/mes_recettesController.php" method="POST">
                    <!-- Bouton HIDDEN : récupération du N° de la recette -->
                    <input name="ID_RECET" type="hidden" value="<?php echo ($donnees['ID_RECET']); ?>">
                    <!--Nouveau COMMENTAIRE : COM_USER; (A faire en SHOW/HIDE) -->
                    <label for="COM_USER">Entrez votre commentaire :</label>
                    <textarea name="COM_USER" type="texte" value="" maxlength="70" class="w-95 mr-1 ml-1" placeholder="(70 caractères maximum)"></textarea>
                    <input type="submit" />
                  </form>
                  <button class="btn btn-secondary btn-md mt-2" type="button" data-toggle="collapse" data-target="#deplieCommentaires<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieCommentaires<?php echo ($donnees['ID_RECET']); ?>">X</button>
                </div>
              </div>
              <!--FIN du SHOW/HIDDEN pour les COMMENTAIRES-->

              <!--SHOW/HIDDEN pour le STEEP-->
              <div class="collapse mt-2" id="deplieSteep<?php echo ($donnees['ID_RECET']); ?>">
                <div class="row">
                  <form action="../controllers/mes_recettesController.php" method="POST">
                    <!-- Bouton HIDDEN : récupération du N° de la recette -->
                    <input name="ID_RECET" type="hidden" value="<?php echo ($donnees['ID_RECET']); ?>">
                    <!--Nouveau STEEP : ETOILES; (A faire en SHOW/HIDE) -->
                    <label for="ETA_STEE">Actualisez le Steep :</label>
                    <select name="ETA_STEE">
                      <option>STEEP</option>
                      <option>PRETE</option>
                      <option>FINIE</option>
                    </select>
                    <input type="submit" />
                  </form>
                  <button class="btn btn-secondary btn-md mt-2" type="button" data-toggle="collapse" data-target="#deplieSteep<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieSteep<?php echo ($donnees['ID_RECET']); ?>">X</button>
                </div>
              </div>
              <!--FIN du SHOW/HIDDEN pour le STEEP-->

              <!--SHOW/HIDDEN pour SUPPRIMER-->
              <div class="collapse mt-2" id="deplieSupprimer<?php echo ($donnees['ID_RECET']); ?>">
                <div class="row">
                  <form action="../controllers/mes_recettesController.php" method="POST">
                    <!-- Bouton HIDDEN : récupération du N° de la recette -->
                    <input name="ID_RECET" type="hidden" value="<?php echo ($donnees['ID_RECET']); ?>">
                    <!--Nouveau STEEP : ETOILES; (A faire en SHOW/HIDE) -->
                    <label for="AFF_RECET">Rendre cette recette inactive ?</label>
                    <select name="AFF_RECET">
                      <option value="non">Oui</option>
                      <option value="oui">Non</option>
                    </select>
                    <input type="submit" value="Confirmer" />
                  </form>
                  <button class="btn btn-secondary btn-md mt-2" type="button" data-toggle="collapse" data-target="#deplieSupprimer<?php echo ($donnees['ID_RECET']); ?>" aria-expanded="false" aria-controls="deplieSupprimer<?php echo ($donnees['ID_RECET']); ?>">X</button>
                </div>
              </div> <!--FIN du SHOW/HIDDEN SUPPRIMER-->
            </div>
          </div>
        </div>
        <?php } ?><!--fin de la partie à faire BOUCLER-->
      </div><!--fin de Div ROW (hors du FETCH)-->
    </div>
  </div><!-- fin DIV CONTAINER principal -->

  <!-- jQuery first, then Tether, then Bootstrap JS. -->
  <script src="static/js/jquery-3.1.1.slim.min.js" type="text/javascript"></script>
  <script src="static/js/tether.min.js" type="text/javascript"></script>
  <script src="static/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>