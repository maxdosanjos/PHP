<?php
require_once ( dirname ( __FILE__ ) . "/PersonVO.class.php");
class PersonEntity extends Person  {
	
	CONST ISENTO = "ISENTO";
	
	private $cnpj;
	private $ie;
	private $contact;

	public function __construct(){
		$this->setType(Person::PJ);
	}

	public function setCnpj($cnpj){
		$cnpj = trim($cnpj);
		$cnpj = preg_replace("/[\-\.\/\\\]/i","",$cnpj);
		$maxlength = 14;
		if(strlen($cnpj) > $maxlength){
			$cnpj = substr($cnpj,0,$maxlength);
		}
		$this->cnpj = $cnpj;
	}

	public function getCnpj(){
		return $this->cnpj;
	}


	public function setIe($ie){
		$maxlength = 18;
		if(strlen($ie) > $maxlength){
			$ie = substr($ie,0,$maxlength);
		}
		$this->ie = $ie;
	}

	public function getIe(){
		return $this->ie;
	}

	public function setContact($contact){
		$maxlength = 255;
		$contact = trim($contact);
		if(strlen($contact) > $maxlength){
			$contact = substr($contact,0,$maxlength);
		}
		$this->contact = $contact;
	}

	public function getContact(){
		return $this->contact;
	}

	public function toString(){
		return "PersonEntity [
				cnpj => ".$this->getCnpj().", 
				corporateName => ".$this->getCorporateName().", 
				ie => ".$this->getIe().", 
				contact => ".$this->getContact()."]";
	}
}
?>