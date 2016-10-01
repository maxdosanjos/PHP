<?php
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Util.class.php");
class Phone {
	private $id;
	private $ddi;
	private $ddd;
	private $phone;

	public function __construct(){
		$this->setDdi("55");
	}

	public function setId($id){
		$this->id = Util::bigIntval($id);
	}

	public function getId(){
		return $this->id;
	}

	public function setDdi($ddi){
		$maxlength = 3;
		$ddi = trim($ddi);
		if(strlen($ddi) > $maxlength){
			$ddi = substr($ddi,0,$maxlength);
		}
		$this->ddi = $ddi;
	}

	public function getDdi(){
		return $this->ddi;
	}

	public function setDdd($ddd){
		$maxlength = 3;
		$ddd = trim($ddd);
		if(strlen($ddd) > $maxlength){
			$ddd = substr($ddd,0,$maxlength);
		}
		$this->ddd = $ddd;
	}

	public function getDdd(){
		return $this->ddd;
	}

	public function setPhone($phone){
		$maxlength = 11;
		$phone = trim($phone);
		$phone = preg_replace ("([^0-9])", "", $phone);
		if(strlen($phone) > $maxlength){
			$ddd = substr($phone,0,$maxlength);
		}
		$this->phone = $phone;
	}

	public function getPhone(){
		return $this->phone;
	}
	
	public function setPhoneByMask($phone){
		$phone = trim($phone);		
		$this->setDdi("55");		
		$this->setDdd(substr($phone,1,2));		
		$this->setPhone(substr($phone,4,11));
	}
	public function getPhoneMask(){
		return "(".$this->getDdd().") ".substr($this->getPhone(),0,4)."-".substr($this->getPhone(),4,11);
	}

	public function toString(){
		return "Phone [
				id => ".$this->getId().", 
				ddi => ".$this->getDdi().", 
				ddd => ".$this->getDdd().", 
				phone => ".$this->getPhone()."]";
	}
}
?>