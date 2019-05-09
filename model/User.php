<?php

class User {
	private $_id;
	private $_nom;
	private $_mail;
	private $_aff;
	private $_pass;

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
	    $this->_id = (int)($id);
	}
	public function setNOM_USER($nom){
	    $this->_nom = htmlspecialchars($nom);
	}
	public function setMAIL_USER($mail){
	    $this->_mail = htmlspecialchars($mail);
	}
	public function setAFF_USER($aff){
		$this->_aff = strtolower($aff);
	}
	public function setPASSWD($pass){
	    $this->_pass = sha1(htmlspecialchars($pass));
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le setter mailespondant à l'attribut.
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