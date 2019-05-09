<?php

class ParfumerManager extends Manager{

  public function insert(Parfumer $parfumer){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO parfumer (ID_RECET, ID_ARO, DOS_ARO) VALUES(?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $parfumer->idRecette(),
      $parfumer->idArome(),
      $parfumer->dos()
      ));
  }

  public function delete(Parfumer $parfumer){
    // Requête préparée DELETE.
    $sql = "DELETE FROM parfumer WHERE ID_RECET =?";
    $reqRetour = $this->executerRequete($sql, array($parfumer->idRecette() ));
  }

  public function update(Parfumer $parfumer){
    // Requête préparée UPDATE :
    $sql = "UPDATE parfumer SET ID_ARO=?, DOS_ARO=? where ID_RECET=?";
    $reqRetour = $this->executerRequete($sql, array(
      $parfumer->idArome(),
      $parfumer->dos(),
      $parfumer->idRecette()
      ));
  }

  public function select($idRecet){
    // Requête préparée SELECT avec une clause WHERE sur l'idRecette, retourne un objet PDO :
    $sql = "SELECT * FROM parfumer where ID_RECET=?";
    $reqRetour = $this->executerRequete($sql, array($idRecet));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("aucune entrée dans Parfumer ne correspond à cette recette");
  }

  public function selectAll(){
    // Retourne tous les entrées sous forme d'objet PDO.
    $sql = "SELECT * FROM parfumer order by ID_RECET";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($idRecet){
    // Vérifie qu'un ID_RECET existe en table Parfumer : 
    $sql = "SELECT * FROM parfumer";
    $dataParfumer = $this->executerRequete($sql);
    $data = $dataParfumer->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_RECET'] == $idRecet) return true;
    }
    return false;
  }

  public function getDosage($idRecet){
    // Retourne la valeur DOS_ARO associé à un ID_RECET :
    $sql = "SELECT DOS_ARO FROM parfumer where ID_RECET=?";
    $reqRetour = $this->executerRequete($sql, array($idRecet));
    if ($reqRetour->rowCount() == 1) {
      $res = $reqRetour->fetchAll();
      return $res[0]['DOS_ARO']; 
    }
    else throw new Exception("aucun dosage d'arôme n'est associé à cette recette");
  }
}