<?php
class MailAttachment {
	private $path;
	private $name;
	private $encoding;
	private $type;

	public function __construct($path='',$name=''){
		$this->setEncoding("base64");
		$this->setType("application/octet-stream");
		$this->setName($name);
		$this->setPath($path);
	}
	
	public function getPath(){
		return $this->path;
	}
	public function setPath($path){
		$this->path = $path;
	}
	
	public function getName(){
		return $this->name;
	}
	public function setName($name){
		$this->name = $name;
	}
	
	public function getEncoding(){
		return $this->encoding;
	}
	public function setEncoding($encoding){
		$this->encoding = $encoding;
	}
	
	public function getType(){
		return $this->type;
	}
	public function setType($type){
		$this->type = $type;
	}
	
	public function parseByFILES($file){
		$this->setPath($file["tmp_name"]);
		$this->setName($file["name"]);
		$this->setType($file["type"]);
	}
}
?>