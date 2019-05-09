<?php

class Parfumer {
	private $_idRecette;
	private $_idArome;
	private $_dos;

// Contructeur : appelle la méthode hydrate()
	public function __construct (array $donnees) {
		$this->hydrate ($donnees);
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
	    $this->_idRecette = (int)($idRecette);
	}
	public function setID_ARO($idArome){
	    $this->_idArome = (int)($idArome);
	}
	public function setDOS_ARO($dos){
	    if(strstr($dos, ",") || strstr($dos, ".")) { // Si nombre réel
			if (strstr($dos, ",")){
		   	 $dos = str_replace(",", ".", $dos); // remplace ',' par '.'
		    }
			$dos = (float)($dos);
		} 
	    $this->_dos = $dos;
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le setter dosespondant à l'attribut.
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