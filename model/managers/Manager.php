<?php  
abstract class Manager {
  private $host = 'localhost';
  private $db = 'diy_1'; 
  private $login = 'root'; 
  private $password = '';  // 
  private $bdd; // objet PDO

   // Réinitialise la connexion au besoin :
  private function getBdd() {
      if ($this->bdd == null) {
        // Création de la connexion
        $this->bdd = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8', $this->login, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      return $this->bdd;
  }

  protected function executerRequete($sql, $params = null) {
      if ($params == null) {
        $resultat = $this->getBdd()->query($sql);    // exécution directe
      }
      else {
        $resultat = $this->getBdd()->prepare($sql);  // requête préparée
        $resultat->execute($params);
      }
      return $resultat;
  }

  protected function executerTransaction($sql1, $params1, $sql2, $params2) {
    try {
      // Début de la transaction:
      $myConnexion = $this->getBdd();
      $myConnexion->beginTransaction();

      $firstQuery = $myConnexion->prepare($sql1);
      $firstQuery->execute($params1);

      // Si les requetes sont de type INSERT :
      if(preg_match('/(INSERT|insert)/m', $sql1)) {
        // Récupération de l'ID_RECET en cours de création, insertion à l'index '1' de $newParams2 :
        $id_nouveau = $myConnexion->lastInsertId();
        $newParams2 = array (0=>$params2[0], 1=>$id_nouveau, 2=>$params2[1]);
        $secondQuery = $myConnexion->prepare($sql2);
        $secondQuery->execute($newParams2);
      }
      // Si les requetes sont de type UPDATE :
      else {
        $secondQuery = $myConnexion->prepare($sql2);
        $secondQuery->execute($params2);
      } 
      // Effectue la transaction:
      $myConnexion->commit();
      $myConnexion = null; //Ferme la connexion PDO
    } 

    catch (PDOException $e) {
      $myConnexion->rollBack(); //Annule la transaction en cours
      $myConnexion = null; //Ferme la connexion PDO
      throw new Exception("une erreur d'insertion s'est produite") ;
    }
  }
}
?>