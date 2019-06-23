<?php

class BaseManager extends Manager{

  public function insert(Base $base){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO base (DOS_PG, DOS_VG, CORRECTIF) VALUES(?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $base->pg(),
      $base->vg(),
      $base->corr()
      ));
  }

  public function delete(Base $base){
    // Requête préparée DELETE :
    $sql = "DELETE FROM base WHERE ID_BASE =?";
    $reqRetour = $this->executerRequete($sql, array($base->id() ));
  }

  public function update(Base $base){
    // Requête préparée UPDATE :
    $sql = "UPDATE base SET DOS_PG=?, DOS_VG=?, CORRECTIF=? where ID_BASE=?";
    $reqRetour = $this->executerRequete($sql, array(
      $base->pg(),
      $base->vg(),
      $base->corr(),
      $base->id()
      ));
  }

  public function select($id){
    // Requête préparée SELECT avec une clause WHERE sur l'id, retourne un objet PDO :
    $sql = "SELECT * FROM base where ID_BASE=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("aucune base ne correspond à cet identifiant");
  }

  public function selectAll(){
    // Retourne tous les bases sous forme d'objet PDO.
    $sql = "SELECT * FROM base order by ID_BASE";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Vérifie qu'un ID_BASE existe en BDD : 
    $sql = "SELECT * FROM base";
    $dataBase = $this->executerRequete($sql);
    $data = $dataBase->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_BASE'] == $id) return true;
    }
    return false;
  }

  public function getCorrectif($id){
    // Retourne la valeur CORRECTIF d'un ID :
    $sql = "SELECT CORRECTIF FROM base where ID_BASE=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) {
      $res = $reqRetour->fetchAll();
      return $res[0]['CORRECTIF']; 
    }
    else throw new Exception("aucun correctif ne correspond à cet identifiant");
  }
}