<?php

class AvisValidator {
	private $_id;
	private $_idUser;
	private $_idRecette;
	private $_text;
	private $_note;
	private $_dat;
	private $_aff;
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
   			| !(int)($idUser) || (int)($idUser)<$this->_data_ctrl_class[1]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[1]["LEGEND"]." = ".$idUser.") n'est pas conforme");
			return;
	    }
	    $this->_idUser = (int)($idUser);
	}
	public function setID_RECET($idRecette){
		if (!isset($idRecette)) throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[2]["REGEX"]."/", $idRecette)
   			| !(int)($idRecette) || (int)($idRecette)<$this->_data_ctrl_class[2]["MIN"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[2]["LEGEND"]." = ".$idRecette.") n'est pas conforme");
			return;
	    }
	    $this->_idRecette = (int)($idRecette);
	}
	public function setTEXT_AVI($text){
		if (isset($text)) {
	   		if (!preg_match("#".$this->_data_ctrl_class[3]["REGEX"]."#", $text)
	   			|| strlen($text)<$this->_data_ctrl_class[3]["MINLENGTH"] 
	   			|| strlen($text)>$this->_data_ctrl_class[3]["MAXLENGTH"]) {
				throw new Exception("la valeur (".$this->_data_ctrl_class[3]["LEGEND"]." = ".$text.") n'est pas conforme");
				return;
		    }
		    $this->_text = htmlspecialchars($text);
	    }
	}
	public function setNOTE_AVI($note){
		if (!isset($note)) throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"].") est obligatoire");
   		if (!preg_match("/".$this->_data_ctrl_class[4]["REGEX"]."/", $note)
   			 || (int)($note)<$this->_data_ctrl_class[4]["MIN"]
   			|| (int)($note)>$this->_data_ctrl_class[4]["MAX"]
   			|| strlen($note)>$this->_data_ctrl_class[4]["MAXLENGTH"]) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[4]["LEGEND"]." = ".$note.") n'est pas conforme");
			return;
	    }
	    $this->_note = (int)($note);
	}
	public function setDATE_AVI($dat){
		if (!isset($dat)) throw new Exception("la valeur (".$this->_data_ctrl_class[5]["LEGEND"].") est obligatoire");
		$this->_dat = $dat;
	}
	public function setAFF_AVI($aff){
		if (!isset($aff)) throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"].") est obligatoire");
		$aff = strtolower($aff);
   		if ($aff != "oui" && $aff != "non" ) {
			throw new Exception("la valeur (".$this->_data_ctrl_class[6]["LEGEND"]." = ".$aff.") n'est pas conforme");
			return;
	    }
	    $this->_aff = htmlspecialchars($aff);
	}

	// Pour chaque clé de l'array transmis, appelle le setter s'il existe :
	public function checkAll(array $donnees){
		foreach ($donnees as $key => $value){
			$method = 'set'.($key);
			if (method_exists($this, $method)){
			  $this->$method($value);
			}
		}
	}
}
?>