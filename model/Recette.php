<?php

class Recette {
	private $_id;
	private $_idUser;
	private $_idBase;
	private $_datRecet;
	private $_qteAro;
	private $_qteBase;
	private $_qteTot;
	private $_datStee;
	private $_etaStee;
	private $_comUser;
	private $_aff;
	private $_etoiles;

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
	public function idBase(){
   		return $this->_idBase;
	}
	public function datRecet(){
   		return $this->_datRecet;
	}
	public function qteAro(){
   		return $this->_qteAro;
	}
	public function qteBase(){
   		return $this->_qteBase;
	}
	public function qteTot(){
   		return $this->_qteTot;
	}
	public function datStee(){
   		return $this->_datStee;
	}
	public function etaStee(){
   		return $this->_etaStee;
	}
	public function comUser(){
   		return $this->_comUser;
	}
	public function aff(){ 
   		return $this->_aff;
	}
	public function etoiles(){
   		return $this->_etoiles;
	}
	
// Setters :
	public function setID_RECET($id){
	    $this->_id = (int)($id);
	}
	public function setID_USER($idUser){
	    $this->_idUser = (int)($idUser);
	}
	public function setID_BASE($idBase){
	    $this->_idBase = (int)($idBase);
	}
	public function setDAT_RECET($datRecet){
	    $this->_datRecet = $datRecet;
	}
	public function setQTE_ARO($qteAro){
	    if(strstr($qteAro, ",") || strstr($qteAro, ".")) { // Si nombre réel
			if (strstr($qteAro, ",")){
		   	 $qteAro = str_replace(",", ".", $qteAro); // remplace ',' par '.'
		    }
			$qteAro = (float)($qteAro);
		} 
	    $this->_qteAro = $qteAro;
	}
	public function setQTE_BAS($qteBase){
		if(strstr($qteBase, ",") || strstr($qteBase, ".")) { // Si nombre réel
			if (strstr($qteBase, ",")){
		   	 $qteBase = str_replace(",", ".", $qteBase); // remplace ',' par '.'
		    }
			$qteBase = (float)($qteBase);
		} 
	    $this->_qteBase = $qteBase;
	}
	public function setQTE_TOT($qteTot){
		if(strstr($qteTot, ",") || strstr($qteTot, ".")) { // Si nombre réel
			if (strstr($qteTot, ",")){
		   	 $qteTot = str_replace(",", ".", $qteTot); // remplace ',' par '.'
		    }
			$qteTot = (float)($qteTot);
		} 
	    $this->_qteTot = $qteTot;
	}
	public function setDAT_STEE($datStee){
		$this->_datStee = $datStee;
	}
	public function setETA_STEE($etaStee){
		$this->_etaStee = strtoupper($etaStee);
	}
	public function setCOM_USER($comUser){
		$this->_comUser = ucfirst($comUser);
	}
	public function setAFF_RECET($aff){
	    $this->_aff = strtolower($aff);
	}
	public function setETOILES($etoiles){
		$this->_etoiles = (int)($etoiles);
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le idUser du setter qteBaseespondant à l'attribut.
			$method = 'set'.($key);
			// Si le setter qteBaseespondant existe.
			if (method_exists($this, $method)){
			  // On appelle le setter.
			  $this->$method($value);
			}
		}
	}
}
?>