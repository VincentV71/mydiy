<?php

class BaseValidator {
	private $_id;
	private $_pg;
	private $_vg;
	private $_corr;
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
	public function pg(){
   		return $this->_pg;
	}
	public function vg(){
   		return $this->_vg;
	}
	public function corr(){
   		return $this->_corr;
	}
	
// Setters :
	public function setID_BASE($id){
		if (!isset($id)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $id)
   			|| !(int)($id) || (int)($id)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$id.") n'est pas conforme");
			return;
	    }
	    $this->_id = (int)($id);
	}
	public function setDOS_PG($pg){ 
		if (!isset($pg)) throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[1]["REGEX"]."/", $pg)
   			|| (int)($pg)<$this->_data_ctrl_class[1]["MIN"] || (int)($pg)>$this->_data_ctrl_class[1]["MAX"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$pg.") n'est pas conforme");
			return;
	    }
	    $this->_pg = (int)($pg);
	}
	public function setDOS_VG($vg){
		if (!isset($vg)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $vg)
   			 || (int)($vg)<$this->_data_ctrl_class[2]["MIN"] || (int)($vg)>$this->_data_ctrl_class[2]["MAX"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$vg.") n'est pas conforme");
			return;
	    }
	    $this->_vg = (int)($vg);
	}
	public function setCORRECTIF($corr){
		if (isset($corr)) {
			if (strstr($corr, ",")){
		   	 $corr = str_replace(",", ".", $corr); // remplace ',' par '.'
		   	 $corr = (float)($corr);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[3]["REGEX"]."/", $corr) || !(float)($corr)
	   			|| (float)($corr)<$this->_data_ctrl_class[3]["MIN"] 
	   			|| (float)($corr)>$this->_data_ctrl_class[3]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"]." = ".$corr.") n'est pas conforme");
				return;
		    }
		    $this->_corr = $corr;
	    }
	}
	
// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le setter correspondant à l'attribut.
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