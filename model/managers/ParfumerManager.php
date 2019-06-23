<?php

class ParfumerManager extends Manager{

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