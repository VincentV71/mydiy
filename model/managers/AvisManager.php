<?php

class AvisManager extends Manager{

  public function insert(Avis $avis){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO avis (ID_USER, ID_RECET, TEXT_AVI, NOTE_AVI, DATE_AVI, AFF_AVI) VALUES(?,?,?,?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $avis->idUser(),
      $avis->idRecette(),
      $avis->text(),
      $avis->note(),
      $avis->dat(),
      $avis->aff()
      ));
  }

  public function delete(Avis $avis){
    // Requête préparée DELETE.
    $sql = "DELETE FROM avis WHERE ID_AVIS =?";
    $reqRetour = $this->executerRequete($sql, array($avis->id() ));
  }

  public function update(Avis $avis){
    // Requête préparée UPDATE :
    $sql = "UPDATE avis SET ID_USER=?, ID_RECET=?, TEXT_AVI=?, NOTE_AVI=?, DATE_AVI=?, AFF_AVI=? where ID_AVIS=?";
    $reqRetour = $this->executerRequete($sql, array(
      $avis->idUser(),
      $avis->idRecette(),
      $avis->text(),
      $avis->note(),
      $avis->dat(),
      $avis->aff(),
      $avis->id()
      ));
  }

  public function select($id){
    // Retourne un objet PDO :
    $sql = "SELECT * FROM avis where ID_AVIS=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("cet ID n'existe pas dans la table Avis");
  }

  public function selectAll(){
    // Retourne tous les entrées sous forme d'objet PDO.
    $sql = "SELECT * FROM avis order by ID_AVIS";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Retourne true ou False : 
    $sql = "SELECT * FROM avis";
    $dataAvis = $this->executerRequete($sql);
    $data = $dataAvis->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_AVIS'] == $id) return true;
    }
    return false;
  }
}