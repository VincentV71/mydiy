<?php

class Prix {
	private $_id;
	private $_idArome;
	private $_prix;
	private $_qte;
	private $_fournis;
	private $_web;

// Contructeur : appelle la méthode hydrate()
	public function __construct (array $donnees) {
		$this->hydrate ($donnees);
	}
// Getters :
	public function id(){
   		return $this->_id;
	}
	public function idArome(){
   		return $this->_idArome;
	}
	public function prix(){
   		return $this->_prix;
	}
	public function qte(){
   		return $this->_qte;
	}
	public function fournis(){
   		return $this->_fournis;
	}
	public function web(){
   		return $this->_web;
	}
	
// Setters :
	public function setID_PRIX($id){
	    $this->_id = (int)($id);
	}
	public function setID_ARO($idArome){
	    $this->_idArome = (int)($idArome);
	}
	public function setPRIX($prix){
	    if(strstr($prix, ",") || strstr($prix, ".")) { // Si nombre réel
			if (strstr($prix, ",")){
		   	 $prix = str_replace(",", ".", $prix); // remplace ',' par '.'
		    }
			$prix = (float)($prix);
		} 
	    $this->_prix = $prix;
	}
	public function setQTE_BTLLE($qte){
		if(strstr($qte, ",") || strstr($qte, ".")) { // Si nombre réel
			if (strstr($qte, ",")){
		   	 $qte = str_replace(",", ".", $qte); // remplace ',' par '.'
		    }
			$qte = (float)($qte);
		} 
	    $this->_qte = $qte;
	}
	public function setFOURNIS($fournis){
	    $this->_fournis = ucwords(htmlspecialchars($fournis));
	}
	public function setE_COM($web){
	    $this->_web = strtolower(htmlspecialchars($web));
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le setter prixespondant à l'attribut.
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