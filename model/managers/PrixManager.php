<?php

class PrixManager extends Manager{

  public function insert(Prix $prix){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO prix (ID_ARO, PRIX, QTE_BTLLE, FOURNIS, E_COM) VALUES(?,?,?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $prix->idArome(),
      $prix->prix(),
      $prix->qte(),
      $prix->fournis(),
      $prix->web()
      ));
  }

  public function delete(Prix $prix){
    // Requête préparée DELETE.
    $sql = "DELETE FROM prix WHERE ID_PRIX =?";
    $reqRetour = $this->executerRequete($sql, array($prix->id() ));
  }

  public function update(Prix $prix){
    // Requête préparée UPDATE :
    $sql = "UPDATE prix SET ID_ARO=?, PRIX=?, QTE_BTLLE=?, FOURNIS=?, E_COM=? where ID_PRIX=?";
    $reqRetour = $this->executerRequete($sql, array(
      $prix->idArome(),
      $prix->prix(),
      $prix->qte(),
      $prix->fournis(),
      $prix->web(),
      $prix->id()
      ));
  }

  public function select($id){
    // Retourne un objet PDO :
    $sql = "SELECT * FROM prix where ID_PRIX=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("cet ID n'existe pas dans la table Prix");
  }

  public function selectAll(){
    // Retourne tous les entrées sous forme d'objet PDO.
    $sql = "SELECT * FROM prix order by ID_PRIX";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Retourne true ou False : 
    $sql = "SELECT * FROM prix";
    $dataPrix = $this->executerRequete($sql);
    $data = $dataPrix->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_PRIX'] == $id) return true;
    }
    return false;
  }
}