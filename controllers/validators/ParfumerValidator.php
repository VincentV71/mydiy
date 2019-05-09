<?php

class ParfumerValidator {
	private $_idRecette;
	private $_idArome;
	private $_dos;
	private $_data_ctrl_class;

// Contructeur : affecte les datas de controle, appelle la méthode hydrate()
	public function __construct (array $donnees, array $ctrl_class) {
		$this->_data_ctrl_class = $ctrl_class;
		$this->checkAll ($donnees);
	}
// Getters :
	public function idRecette(){
   		return $this->_idRecette;
	}
	public function idArome(){
   		return $this->_idArome;
	}
	public function dos(){
   		return $this->_dos;
	}
	
// Setters :
	public function setID_RECET($idRecette){
		if (!isset($idRecette)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $idRecette)
   			|| !(int)($idRecette) || (int)($idRecette)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$idRecette.") n'est pas conforme");
			return;
	    }
	    $this->_idRecette = (int)($idRecette);
	}
	public function setID_ARO($idArome){ 
		if (!isset($idArome)) throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[1]["REGEX"]."/", $idArome)
   			| !(int)($idArome) || (int)($idArome)<$this->_data_ctrl_class[1]["MIN"] ) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$idArome.") n'est pas conforme");
			return;
	    }
	    $this->_idArome = (int)($idArome);
	}
	public function setDOS_ARO($dos){
		if (isset($dos)) {
			if (strstr($dos, ",")){
		   	 $dos = str_replace(",", ".", $dos); // remplace ',' par '.'
		   	 $dos = (float)($dos);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $dos) || !(float)($dos)
	   			|| (float)($dos)<$this->_data_ctrl_class[2]["MIN"] 
	   			|| (float)($dos)>$this->_data_ctrl_class[2]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$dos.") n'est pas conforme");
				return;
		    }
		    $this->_dos = $dos;
	    }
	}
	
// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Construit le nom du setter :
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