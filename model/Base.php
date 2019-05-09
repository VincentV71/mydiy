<?php

class Base {
	private $_id;
	private $_pg;
	private $_vg;
	private $_corr;

// Contructeur : appelle la méthode hydrate()
	public function __construct (array $donnees) {
		$this->hydrate ($donnees);
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
	    $this->_id = (int)($id);
	}
	public function setDOS_PG($pg){
	    $this->_pg = (int)($pg);
	}
	public function setDOS_VG($vg){
	    $this->_vg = (int)($vg);
	}
	public function setCORRECTIF($corr){
		if(strstr($corr, ",") || strstr($corr, ".")) { // Si nombre réel
			if (strstr($corr, ",")){
		   	 $corr = str_replace(",", ".", $corr); // remplace ',' par '.'
		    }
			$corr = (float)($corr);
		} 
	    $this->_corr = $corr;
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
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