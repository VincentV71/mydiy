<?php

class RecetteManager extends Manager{

  public function insert(Recette $recette, Parfumer $parfumer){
    // Objets Recette et Parfumer en arguments pour insertion par Transaction :
    $sql1 = "INSERT INTO recette (ID_USER, ID_BASE, DAT_RECET, QTE_ARO, QTE_BAS, QTE_TOT, DAT_STEE, ETA_STEE, COM_USER, AFF_RECET, ETOILES) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $params1 = array(
      $recette->idUser(),
      $recette->idBase(),
      $recette->datRecet(),
      $recette->qteAro(),
      $recette->qteBase(),
      $recette->qteTot(),
      $recette->datStee(),
      $recette->etaStee(),
      $recette->comUser(),
      $recette->aff(),
      $recette->etoiles()
      );

    $sql2 = "INSERT INTO parfumer (ID_ARO, ID_RECET, DOS_ARO) VALUES(?,?,?)";
    $params2 = array(
      $parfumer->idArome(), 
      $parfumer->dos()
      );

    $reqRetour = $this->executerTransaction($sql1, $params1, $sql2, $params2); 
  }

  public function delete(Recette $recette){
    // Requête préparée DELETE.
    $sql = "DELETE FROM recette WHERE ID_RECET =?";
    $reqRetour = $this->executerRequete($sql, array($recette->id() ));
  }

  public function update(Recette $recette){
    // Requête préparée UPDATE :
    $sql = "UPDATE recette SET ID_USER=?, ID_BASE=?, DAT_RECET=?, QTE_ARO=?, QTE_BAS=?, QTE_TOT=?, DAT_STEE=?, ETA_STEE=?, COM_USER=?, AFF_RECET=?, ETOILES=? where ID_RECET=?";
    $reqRetour = $this->executerRequete($sql, array(
      $recette->idUser(),
      $recette->idBase(),
      $recette->datRecet(),
      $recette->qteAro(),
      $recette->qteBase(),
      $recette->qteTot(),
      $recette->datStee(),
      $recette->etaStee(),
      $recette->comUser(),
      $recette->aff(),
      $recette->etoiles(),
      $recette->id()
      ));
  }

  public function updateTransac(Recette $recette, Parfumer $parfumer){
    // requête UPDATE par Transaction :
    $sql1 = "UPDATE recette SET ID_USER=?, ID_BASE=?, DAT_RECET=?, QTE_ARO=?, QTE_BAS=?, QTE_TOT=?, DAT_STEE=?, ETA_STEE=?, COM_USER=?, AFF_RECET=?, ETOILES=? where ID_RECET=?";
    $params1 = array(
      $recette->idUser(),
      $recette->idBase(),
      $recette->datRecet(),
      $recette->qteAro(),
      $recette->qteBase(),
      $recette->qteTot(),
      $recette->datStee(),
      $recette->etaStee(),
      $recette->comUser(),
      $recette->aff(),
      $recette->etoiles(),
      $recette->id()
      );

    $sql2 = "UPDATE parfumer SET ID_ARO=?, DOS_ARO=? where ID_RECET=?";
    $params2 = array(
      $parfumer->idArome(),
      $parfumer->dos(),
      $parfumer->idRecette()
      );

    $reqRetour = $this->executerTransaction($sql1, $params1, $sql2, $params2);
  }

  public function select($id){
    // Requête préparée SELECT avec une clause WHERE sur l'id, retourne un objet PDO :
    $sql = "SELECT * FROM recette where ID_RECET=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("aucune recette ne correspond à cet identifiant");
  }

  public function selectAll(){
    // Retourne tous les recettes sous forme d'objet PDO.
    $sql = "SELECT * FROM recette order by ID_RECET";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Vérifie qu'un ID_RECET existe en BDD : 
    $sql = "SELECT * FROM recette order by ID_USER";
    $dataRecette = $this->executerRequete($sql);
    $data = $dataRecette->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_RECET'] == $id) return true;
    }
    return false;
  }
  // from recetteManage :
  public function getAllRecetUser($idUser, $aff, $order) {
    // Retourne les recettes d'un User : actives ou inactives ($aff), triées ($order) :
    $sql = "SELECT *, base.DOS_PG, base.DOS_VG FROM recette INNER JOIN base ON recette.ID_base = base.ID_base INNER JOIN parfumer ON recette.ID_RECET = parfumer.ID_RECET INNER JOIN arome ON parfumer.ID_ARO = arome.ID_ARO WHERE ID_USER=? AND AFF_RECET=?  ORDER BY ".$order." ";
    $reqRetour = $this->executerRequete($sql, array(
      $idUser,
      $aff
      ));
    return $reqRetour; 
  }
}