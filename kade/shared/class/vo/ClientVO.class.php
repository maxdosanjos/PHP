<?php
require_once ( dirname ( __FILE__ ) . "/UserVO.class.php");
class Client {
	private $user;
	
	public function getUser(){
		return $this->user;
	}
	public function setUser(User $user){
		$this->user = $user;
	}
	
	public function __construct(){
	}

	public function toString(){
	}
}
?>