<?php

class PrixValidator {
	private $_id;
	private $_idArome;
	private $_prix;
	private $_qte;
	private $_fournis;
	private $_web;
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
		if (!isset($id)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $id)
   			|| !(int)($id) || (int)($id)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$id.") n'est pas conforme");
			return;
	    }
	    $this->_id = (int)($id);
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
	public function setPRIX($prix){
		if (!isset($prix)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
		if (isset($prix)) {
			if (strstr($prix, ",")){
		   	 $prix = str_replace(",", ".", $prix); // remplace ',' par '.'
		   	 $prix = (float)($prix);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $prix) || !(float)($prix)
	   			|| (float)($prix)<$this->_data_ctrl_class[2]["MIN"] 
	   			|| (float)($prix)>$this->_data_ctrl_class[2]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$prix.") n'est pas conforme");
				return;
		    }
		    $this->_prix = $prix;
	    }
	}
	public function setQTE_BTLLE($qte){
		if (!isset($qte)) throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"].") est obligatoire");
		if (strstr($qte, ",")){
	   	 $qte = str_replace(",", ".", $qte); // remplace ',' par '.'
	   	 $qte = (float)($qte);
	    }
   		if (!preg_match("/".$this->_data_ctrl_class[3]["REGEX"]."/", $qte) || !(float)($qte)
   			|| (float)($qte)<$this->_data_ctrl_class[3]["MIN"] 
   			|| (float)($qte)>$this->_data_ctrl_class[3]["MAX"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"]." = ".$qte.") n'est pas conforme");
			return;
	    }
	    $this->_qte = $qte;
	}
	public function setFOURNIS($fournis){
		if (!isset($fournis)) throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[4]["REGEX"]."/", $fournis)
   			|| strlen($fournis)<$this->_data_ctrl_class[4]["MINLENGTH"] 
   			|| strlen($fournis)>$this->_data_ctrl_class[4]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"]." = ".$fournis.") n'est pas conforme");
			return;
	    }
	    $this->_fournis = ucwords(htmlspecialchars($fournis));
	}
	public function setE_COM($web){
		if (!isset($web)) throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[5]["REGEX"]."/", $web)
   			|| strlen($web)<$this->_data_ctrl_class[5]["MINLENGTH"] 
   			|| strlen($web)>$this->_data_ctrl_class[5]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"]." = ".$web.") n'est pas conforme");
			return;
	    }
	    $this->_web = strtolower(htmlspecialchars($web));
	}
	
// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Construit le fournis du setter :
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