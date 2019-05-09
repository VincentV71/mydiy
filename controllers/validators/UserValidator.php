<?php

class UserValidator {
	private $_id;
	private $_nom;
	private $_mail;
	private $_aff;
	private $_pass;
	private $_data_ctrl_class;

// Contructeur : affecte les datas de controle, appelle la méthode hydrate()
	public function __construct (array $donnees, array $ctrl_class) {
		$this->_data_ctrl_class = $ctrl_class;
		$this->checkAll ($donnees);
	}
// Getters :
	public function id(){
   		return $this->_id;
	}
	public function nom(){
   		return $this->_nom;
	}
	public function mail(){
   		return $this->_mail;
	}
	public function aff(){
   		return $this->_aff;
	}
	public function pass(){
   		return $this->_pass;
	}
	
// Setters :
	public function setID_USER($id){
		if (!isset($id)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $id)
   			|| !(int)($id) || (int)($id)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$id.") n'est pas conforme");
			return;
	    }
	    $this->_id = (int)($id);
	}
	public function setNOM_USER($nom){ 
		if (!isset($nom)) throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[1]["REGEX"]."/", $nom)
   			|| strlen($nom)<$this->_data_ctrl_class[1]["MINLENGTH"] 
   			|| strlen($nom)>$this->_data_ctrl_class[1]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$nom.") n'est pas conforme");
			return;
	    }
	    $this->_nom = htmlspecialchars($nom);
	}
	public function setMAIL_USER($mail){
		if (!isset($mail)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $mail)
   			|| strlen($mail)<$this->_data_ctrl_class[2]["MINLENGTH"] 
   			|| strlen($mail)>$this->_data_ctrl_class[2]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$mail.") n'est pas conforme");
			return;
	    }
	    $this->_mail = htmlspecialchars($mail);
	}
	public function setAFF_USER($aff){
		if (!isset($aff)) throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"].") est obligatoire");
		$aff = strtolower($aff);
   		if ($aff != "oui" && $aff != "non" ) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"]." = ".$aff.") n'est pas conforme");
			return;
	    }
	    $this->_aff = htmlspecialchars($aff);
	}
	public function setPASSWD($pass){
		if (!isset($pass)) throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[4]["REGEX"]."/", $pass)
   			|| strlen($pass)<$this->_data_ctrl_class[4]["MINLENGTH"] 
   			|| strlen($pass)>$this->_data_ctrl_class[4]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"]." = ".$pass.") n'est pas conforme");
			return;
	    }
	    $this->_pass = htmlspecialchars($pass);
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le setter correspondant à l'attribut.
			$method = 'set'.($key);
			// Si le setter de existe :
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
}
?>