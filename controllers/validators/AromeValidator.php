<?php

class AromeValidator {
	private $_id;
	private $_nom;
	private $_fab;
	private $_dos;
	private $_stee;
	private $_cat;
	private $_aff;
	private $_data_ctrl_class;

// Contructeur : affecte les datas de controle, appelle la méthode checkAll()
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
	public function fab(){
   		return $this->_fab;
	}
	public function dos(){
   		return $this->_dos;
	}
	public function stee(){
   		return $this->_stee;
	}
	public function cat(){
   		return $this->_cat;
	}
	public function aff(){
   		return $this->_aff;
	}
	
// Setters :
	public function setID_ARO($id){
		if (!isset($id)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $id)
   			|| !(int)($id) || (int)($id)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$id.") n'est pas conforme");
			return;
	    }
	    $this->_id = (int)($id);
	}
	public function setNOM_ARO($nom){ 
		if (!isset($nom)) throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[1]["REGEX"]."/", $nom)
   			|| strlen($nom)<$this->_data_ctrl_class[1]["MINLENGTH"] 
   			|| strlen($nom)>$this->_data_ctrl_class[1]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$nom.") n'est pas conforme");
			return;
	    }
	    $this->_nom = htmlspecialchars($nom);
	}
	public function setFAB_ARO($fab){
		if (!isset($fab)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $fab)
   			|| strlen($fab)<$this->_data_ctrl_class[2]["MINLENGTH"] 
   			|| strlen($fab)>$this->_data_ctrl_class[2]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$fab.") n'est pas conforme");
			return;
	    }
	    $this->_fab = htmlspecialchars($fab);
	}
	public function setDOS_FAB($dos){
		if (!isset($dos)) throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[3]["REGEX"]."/", $dos)
   			|| !((int)($dos)) || (int)($dos)<$this->_data_ctrl_class[3]["MIN"]
   			|| (int)($dos)>$this->_data_ctrl_class[3]["MAX"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"]." = ".$dos.") n'est pas conforme");
			return;
	    }
	    $this->_dos = (int)($dos);
	}
	public function setNB_J_STEE($stee){
		if (!isset($stee)) throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[4]["REGEX"]."/", $stee)
   			|| !(int)($stee) || (int)($stee)<$this->_data_ctrl_class[4]["MIN"]
   			|| (int)($stee)>$this->_data_ctrl_class[4]["MAX"]
   			|| strlen($stee)>$this->_data_ctrl_class[4]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"]." = ".$stee.") n'est pas conforme");
			return;
	    }
	    $this->_stee = (int)($stee);
	}
	public function setCAT_ARO($cat){
		if (isset($cat)) {
	   		if (!preg_match("/".$this->_data_ctrl_class[5]["REGEX"]."/", $cat)
	   			|| strlen($cat)<$this->_data_ctrl_class[5]["MINLENGTH"] 
	   			|| strlen($cat)>$this->_data_ctrl_class[5]["MAXLENGTH"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"]." = ".$cat.") n'est pas conforme");
				return;
		    }
		    $this->_cat = htmlspecialchars($cat);
	    }
	}
	public function setAFF_ARO($aff){
		if (!isset($aff)) throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"].") est obligatoire");
		$aff = strtolower($aff);
   		if ($aff != "oui" && $aff != "non" ) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"]." = ".$aff.") n'est pas conforme");
			return;
	    }
	    $this->_aff = htmlspecialchars($aff);
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.($key);
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
}
?>