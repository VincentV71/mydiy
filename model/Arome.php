<?php

class Arome {
	private $_id;
	private $_nom;
	private $_fab;
	private $_dos;
	private $_stee;
	private $_cat;
	private $_aff;

// Contructeur : appelle la méthode hydrate()
	public function __construct (array $donnees) {
		$this->hydrate ($donnees);
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
	    $this->_id = (int)($id);
	}
	public function setNOM_ARO($nom){
	    $this->_nom = ucwords($nom);
	}
	public function setFAB_ARO($fab){
	    $this->_fab = strtoupper($fab);
	}
	public function setDOS_FAB($dos){
	    $this->_dos = (int)($dos);
	}
	public function setNB_J_STEE($stee){
	    $this->_stee = (int)($stee);
	}
	public function setCAT_ARO($cat){
		$this->_cat = ucfirst($cat);
	}
	public function setAFF_ARO($aff){
	    $this->_aff = strtolower($aff);
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
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