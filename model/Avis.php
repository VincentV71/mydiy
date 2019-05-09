<?php

class Avis {
	private $_id;
	private $_idUser;
	private $_idRecette;
	private $_text;
	private $_note;
	private $_dat;
	private $_aff;

// Contructeur : appelle la méthode hydrate()
	public function __construct (array $donnees) {
		$this->hydrate ($donnees);
	}
// Getters :
	public function id(){
   		return $this->_id;
	}
	public function idUser(){
   		return $this->_idUser;
	}
	public function idRecette(){
   		return $this->_idRecette;
	}
	public function text(){
   		return $this->_text;
	}
	public function note(){
   		return $this->_note;
	}
	public function dat(){
   		return $this->_dat;
	}
	public function aff(){
   		return $this->_aff;
	}
	
// Setters :
	public function setID_AVIS($id){
	    $this->_id = (int)($id);
	}
	public function setID_USER($idUser){
	    $this->_idUser = (int)($idUser);
	}
	public function setID_RECET($idRecette){
	    $this->_idRecette = (int)($idRecette);
	}
	public function setTEXT_AVI($text){
	    $this->_text = ucfirst($text);
	}
	public function setNOTE_AVI($note){
	    $this->_note = (int)($note);
	}
	public function setDATE_AVI($dat){
		$this->_dat = $dat;
	}
	public function setAFF_AVI($aff){
	    $this->_aff = strtolower($aff);
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