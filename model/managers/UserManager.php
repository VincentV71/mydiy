<?php

class UserManager extends Manager{

  public function insert(User $user){
    // Requête préparée UPDATE :
    $sql = "INSERT INTO user (NOM_USER, MAIL_USER, AFF_USER, PASSWD) VALUES(?,?,?,?)";
    $reqRetour = $this->executerRequete($sql, array(
      $user->nom(),
      $user->mail(),
      $user->aff(),
      $user->pass()
      ));
  }

  public function delete(User $user){
    // Requête préparée DELETE.
    $sql = "DELETE FROM user WHERE ID_USER =?";
    $reqRetour = $this->executerRequete($sql, array($user->id() ));
  }

  public function update(User $user){
    // Requête préparée UPDATE :
    $sql = "UPDATE user SET NOM_USER=?, MAIL_USER=?, AFF_USER=?, PASSWD=? where ID_USER=?";
    $reqRetour = $this->executerRequete($sql, array(
      $user->nom(),
      $user->mail(),
      $user->aff(),
      $user->pass(),
      $user->id()
      ));
  }

  public function select($id){
    // Retourne un objet PDO :
    $sql = "SELECT * FROM user where ID_USER=?";
    $reqRetour = $this->executerRequete($sql, array($id));
    if ($reqRetour->rowCount() == 1) return $reqRetour; 
    else throw new Exception("cet ID n'existe pas dans la table User");
  }

  public function authentificate($mail, $pass){
    // Vérifie que le couple Mail/Password existe en BDD, retourne un objet PDO :
    $sql = "SELECT * FROM user where MAIL_USER=? AND PASSWD=?";
    $reqRetour = $this->executerRequete($sql, array($mail, $pass));
    if ($reqRetour->rowCount() == 1) return $reqRetour->fetchAll(); 
    else throw new Exception("ce compte utilisateur n'existe pas");
  }

  public function selectAll(){
    // Retourne tous les entrées sous forme d'objet PDO.
    $sql = "SELECT * FROM user order by ID_USER";
    $reqRetour = $this->executerRequete($sql);
    return $reqRetour; 
  }

  public function checkId($id){
    // Retourne true ou False : 
    $sql = "SELECT * FROM user";
    $dataUser = $this->executerRequete($sql);
    $data = $dataUser->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['ID_USER'] == $id) return true;
    }
    return false;
  }
  public function checkEmailAndNom($mail, $name){
    // Vérifie qu'un Email ou un Pseudo sont disponibles en BDD : 
    $sql = "SELECT * FROM user";
    $dataUser = $this->executerRequete($sql);
    $data = $dataUser->fetchAll();
    for ($i=0; $i< sizeof($data); $i++){
      if ($data[$i]['MAIL_USER'] == $mail) throw new Exception("cette adresse e-mail n'est pas disponible");
      if ($data[$i]['NOM_USER'] == $name) throw new Exception("ce pseudo n'est pas disponible");
    }
    return false;
  }
}