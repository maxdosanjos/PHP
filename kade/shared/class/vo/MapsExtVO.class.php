<?php
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Util.class.php");
require_once (dirname ( __FILE__ ) . "/AddressVO.class.php");
class MapsExt {
	private $address;
	private $qtyReal;
	private $qtyIllus;
	
	public function setAddress(Address $address) {
		$this->address = $address;
	}
	public function getAddress() {
		return $this->address;
	}
	
	public function setQtyReal($qtyReal) {
		$this->qtyReal = Util::bigIntval($qtyReal);;
	}
	public function getQtyReal() {
		return $this->qtyReal;
	}
	
	public function setQtyIllus($qtyIllus) {
		$this->qtyIllus = Util::bigIntval($qtyIllus);;
	}
	public function getQtyIllus() {
		return $this->qtyIllus;
	}
}
?>