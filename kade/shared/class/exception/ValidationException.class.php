<?php
class ValidationException extends Exception {
	private $dataList = array();
	
    public function __construct($message) {
    	parent::__construct($message);
    }
    
    public function add($fieldName,$fieldId,$message){
    	$this->dataList[] = array(
			"name" => $fieldName,
			"id" => $fieldId,
			"message" => $message
		);
    }
    
    public function size(){
    	return sizeof($this->dataList);
    }
    
    public function toArray($useHTMLEntities=false){
    	if($useHTMLEntities){
    		$output = array();
	    	foreach($this->dataList AS $item){
	    		$newItem = array(
	    			"name" => htmlentities($item["name"]),
	    			"id" => htmlentities($item["id"]),
	    			"message" => htmlentities($item["message"]),
	    		);
	    		$output[] = $newItem;
	    	}
	    	return $output;
    	}else{
    		return $this->dataList;	
    	}
    }
    
    public function toJSON($useHTMLEntities=false){
    	return json_encode($this->toArray($useHTMLEntities));
    }
}
?>