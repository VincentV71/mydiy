<?php

class RecetteValidator {
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
	private $_data_ctrl_class;

// Contructeur : affecte les datas de controle, appelle la méthode checkAll()
	public function __construct (array $donnees, array $ctrl_class) {
		$this->_data_ctrl_class = $ctrl_class;
		$this->checkAll ($donnees);
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
		if (!isset($id)) throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[0]["REGEX"]."/", $id)
   			|| !(int)($id) || (int)($id)<$this->_data_ctrl_class[0]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[0]["LEGEND"]." = ".$id.") n'est pas conforme");
			return;
	    }
	    $this->_id = (int)($id);
	}
	public function setID_USER($idUser){
		if (!isset($idUser)) throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[1]["REGEX"]."/", $idUser)
   			|| !(int)($idUser) || (int)($idUser)<$this->_data_ctrl_class[1]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$idUser.") n'est pas conforme");
			return;
	    }
	    $this->_idUser = (int)($idUser);
	}
	public function setID_BASE($idBase){
		if (!isset($idBase)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $idBase)
   			|| !(int)($idBase) || (int)($idBase)<$this->_data_ctrl_class[2]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$idBase.") n'est pas conforme");
			return;
	    }
	    $this->_idBase = (int)($idBase);
	}
	public function setDAT_RECET($datRecet){ 
		if (!isset($datRecet)) throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"].") est obligatoire");
	    $this->_datRecet = htmlspecialchars($datRecet);
	}
	public function setQTE_ARO($qteAro){
		if (!isset($qteAro)) throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"].") est obligatoire");
		if (isset($qteAro)) {
			if (strstr($qteAro, ",")){
		   	 $qteAro = str_replace(",", ".", $qteAro); // remplace ',' par '.'
		   	 $qteAro = (float)($qteAro);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[4]["REGEX"]."/", $qteAro) || !(float)($qteAro)
	   			|| (float)($qteAro)<$this->_data_ctrl_class[4]["MIN"] 
	   			|| (float)($qteAro)>$this->_data_ctrl_class[4]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"]." = ".$qteAro.") n'est pas conforme");
				return;
		    }
		    $this->_qteAro = $qteAro;
	    }
	}
	public function setQTE_BAS($qteBase){
		if (!isset($qteBase)) throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"].") est obligatoire");
		if (isset($qteBase)) {
			if (strstr($qteBase, ",")){
		   	 $qteBase = str_replace(",", ".", $qteBase); // remplace ',' par '.'
		   	 $qteBase = (float)($qteBase);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[5]["REGEX"]."/", $qteBase) || !(float)($qteBase)
	   			|| (float)($qteBase)<$this->_data_ctrl_class[5]["MIN"] 
	   			|| (float)($qteBase)>$this->_data_ctrl_class[5]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"]." = ".$qteBase.") n'est pas conforme");
				return;
		    }
		    $this->_qteBase = $qteBase;
	    }
	}
	public function setQTE_TOT($qteTot){
		if (!isset($qteTot)) throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"].") est obligatoire");
		if (isset($qteTot)) {
			if (strstr($qteTot, ",")){
		   	 $qteTot = str_replace(",", ".", $qteTot); // remplace ',' par '.'
		   	 $qteTot = (float)($qteTot);
		    }
	   		if (!preg_match("/".$this->_data_ctrl_class[6]["REGEX"]."/", $qteTot) || !(float)($qteTot)
	   			|| (float)($qteTot)<$this->_data_ctrl_class[6]["MIN"] 
	   			|| (float)($qteTot)>$this->_data_ctrl_class[6]["MAX"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"]." = ".$qteTot.") n'est pas conforme");
				return;
		    }
		    $this->_qteTot = $qteTot;
	    }
	}
	public function setDAT_STEE($datStee){
		if (!isset($datStee)) throw new Exception("la valeur (".$this->_data_ctrl_class[7]["LEGEND"].") est obligatoire");
	    $this->_datStee = htmlspecialchars($datStee);
	}
	public function setETA_STEE($etaStee){
		if (!isset($etaStee)) throw new Exception("la valeur (".$this->_data_ctrl_class[8]["LEGEND"].") est obligatoire");
		if (strtoupper($etaStee) != "PRETE" && strtoupper($etaStee) != "FINIE" && strtoupper($etaStee) != "STEEP" ) 
			throw new Exception("la valeur (".$this->_data_ctrl_class[8]["LEGEND"].") n'est pas conforme");
		$this->_etaStee = strtoupper($etaStee);
	}
	public function setCOM_USER($comUser){
	   	if	(isset($comUser) && strlen($comUser)>0 ){
	   		if (!preg_match("#".$this->_data_ctrl_class[9]["REGEX"]."#", $comUser)
	   			|| strlen($comUser)<$this->_data_ctrl_class[9]["MINLENGTH"] 
	   			|| strlen($comUser)>$this->_data_ctrl_class[9]["MAXLENGTH"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[9]["LEGEND"]." = ".$comUser.") n'est pas conforme");
				return;
		    }
			$this->_comUser = lcfirst($comUser);
		}
	}
	public function setAFF_RECET($aff){
		if (!isset($aff)) throw new Exception("la valeur (".$this->_data_ctrl_class[10]["LEGEND"].") est obligatoire");
		$aff = strtolower($aff);
   		if ($aff != "oui" && $aff != "non" ) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[10]["LEGEND"]." = ".$aff.") n'est pas conforme");
			return;
	    }
	    $this->_aff = htmlspecialchars($aff);
	}
	public function setETOILES($etoiles){
		if	(isset($etoiles) && strlen($etoiles)>0){
	   		if (!preg_match("/".$this->_data_ctrl_class[11]["REGEX"]."/", $etoiles)
	   			|| (int)($etoiles)<$this->_data_ctrl_class[11]["MIN"] || (int)($etoiles)>$this->_data_ctrl_class[11]["MAX"] ) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[11]["LEGEND"]." = ".$etoiles.") n'est pas conforme");
				return;
		    }
		    $this->_etoiles = (int)($etoiles);
	    }
	}

// Méthodes :
	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			// Récupère le idUser du setter correspondant à l'attribut.
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