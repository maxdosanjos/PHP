<?php
require_once ( dirname ( __FILE__ ) . "/UserVO.class.php");
require_once ( dirname ( __FILE__ ) . "/ProfileVO.class.php");
class UserProfile {
	private $user;
	private $profile;
	private $enabled;

	public function __construct(User $user,Profile $profile){
		$this->setUser($user);
		$this->setProfile($profile);
	}

	public function setUser(User $user){
		$this->user = $user;
	}

	public function getUser(){
		return $this->user;
	}

	public function setProfile(Profile $profile){
		$this->profile = $profile;
	}

	public function getProfile(){
		return $this->profile;
	}

	public function setEnabled($enabled){
		$enabled = intval($enabled);
		if($enabled != '0')
			$enabled = '1';		
		$this->enabled = $enabled;
	}

	public function getEnabled(){
		return $this->enabled;
	}

	public function toString(){
		return "UserProfile [
				user => ".$this->getUser().", 
				profile => ".$this->getProfile().", 
				enabled => ".$this->getEnabled()."]";
	}
}
?>