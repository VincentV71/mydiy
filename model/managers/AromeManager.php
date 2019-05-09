<?php

class AromeManager extends Manager{

  public function insert(Arome $arome){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO arome (NOM_ARO, FAB_ARO, DOS_FAB, NB_J_STEE, CAT_ARO, AFF_ARO) VALUES(?,?,?,?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $arome->nom(),
      $arome->fab(),
      $arome->dos(),
      $arome->stee(),
      $arome->cat(),
      $arome->aff()
      ));
  }

  public function delete(Arome $arome){
    // Requête préparée DELETE.
    $sql = "DELETE FROM arome WHERE ID_ARO =?";
    $reqRetour = $this->executerRequete($sql, array($arome->id() ));
  }

  public function update(Arome $arome){
    // Requête préparée UPDATE :
    $sql = "UPDATE arome SET NOM_ARO=?, FAB_ARO=?, DOS_FAB=?, NB_J_STEE=?, CAT_ARO=?, AFF_ARO=? where ID_ARO=?";
    $reqRetour = $this->executerRequete($sql, array(
      $arome->nom(),
      $arome->fab(),
      $arome->dos(),
      $arome->stee(),
      $arome->cat(),
      $arome->aff(),
      $arome->id()
      ));
  }

  public function select($id){
    // Requête préparée SELECT avec une clause WHERE sur l'id, retourne un objet PDO :
    $sql = "SELECT * FROM arome where ID_ARO=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("aucun arôme ne correspond à cet identifiant");
  }

  public function selectAll(){
    // Retourne tous les aromes sous forme d'objet PDO.
    $sql = "SELECT * FROM arome order by NOM_ARO";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Vérifie qu'un ID_ARO existe en BDD : 
    $sql = "SELECT * FROM arome order by NOM_ARO";
    $dataArome = $this->executerRequete($sql);
    $data = $dataArome->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_ARO'] == $id) return true;
    }
    return false;
  }

  public function getSteep($id){
    // Requête préparée SELECT avec une clause WHERE sur l'id, retourne la durée de steep :
    $sql = "SELECT NB_J_STEE FROM arome where ID_ARO=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) {
      $res = $reqRetour->fetchAll();
      return $res[0]['NB_J_STEE']; 
    }
    else throw new Exception("aucun arôme ne correspond à cet identifiant");
  }

}