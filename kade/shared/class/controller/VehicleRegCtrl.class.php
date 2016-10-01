<?php
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/DateTimeCustom.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Util.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Validation.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PhoneVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/AddressVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonIndividualVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonEntityVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/VehicleTypeVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/VehicleContactVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/VehicleTravelingVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/dao/VehicleTypeDAO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/dao/VehicleTravelingDAO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/exception/ValidationException.class.php");
require_once (dirname ( __FILE__ ) . "/AbstractCtrl.class.php");
class VehicleRegCtrl extends AbstractCtrl {
	CONST HRS_EXPIRED = 16;
	
	private $vehicleTypeDAO = null;
	private $vehicleTravelingDAO = null;
	public function __construct() {
		parent::__construct ();
		$this->setAction ( $_REQUEST ["action"] );
		
		
		switch ($this->getAction ()) {
			case "save" :
				$this->onSaveWeb ();
				break;
			case "saveSMS" :
				$this->onSaveSMS ();
				break;
			case "getCaptcha" :
				$this->getImageCaptcha ();
				break;
			default :
		}
	}
	public function onSaveSMS(){
		$_data		= array();
		$inTransaction = false;
		
		
			
		try {
			
			$prop = Properties::getGroup("server_sms");		
			
			if($_SERVER["HTTP_X_REAL_IP"] !=$prop["http_x_real_ip"])
				throw new Exception("IP inválido para tratamento de SMS");			
		
			$_data["vehicle_phone"] = "(".substr($_GET["from"],1,2).") ".substr($_GET["from"],3,11);
			
			list($_data["vehicle_type"],$_data ["vehicle_zipcode"]) = explode("*",$_GET["body"]);			
			
			$vehicleTraveling = $this->getRequestBean ($_data);
			$vehicleTraveling->setSource(VehicleTraveling::SOURCE_SMS);
			
			$address     = $vehicleTraveling->getPersonContact()->getPerson()->getAddress();
			$vehicleType = $vehicleTraveling->getVehicleType ();
			
			try {
				$addressDAO = AddressDAO::getInstance ();
				$db = DataBase::getInstance ( $addressDAO->loadDBConfigCep () );
				$addressDAO->getAddressByZipCode ( $db, $address );
				$db = null;
			} catch ( PDOException $e ) {
				$db = null;
			}
			
			$vehicleTraveling->getPersonContact()->getPerson()->setAddress($address);
			
			$this->validateBean ( $vehicleTraveling );


		
			$this->vehicleTravelingDAO = VehicleTravelingDAO::getInstance ();
				
			$db = DataBase::getInstance ( $this->getDbConfig () );
			$inTransaction = $db->beginTransaction ();
			
			

			$this->vehicleTravelingDAO->insert ( $db, $vehicleTraveling );
			$db->commit ();
			$db = null;
				
			$this->message->setType ( Message::SUCCESS );
			$this->message->setDesc ( "Registro " . $vehicleTraveling->getId () . " realizado com sucesso" );
		} catch ( ValidationException $e ) {
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$_validationException = $e->toArray ( true );
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( json_encode($_validationException) );
			
		} catch ( PDOException $e ) {
				
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
				
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		} catch ( Exception $e ) {
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		}	

	
		try {
			$this->vehicleTravelingDAO = VehicleTravelingDAO::getInstance ();
			$this->vehicleTravelingDAO->registerLogSMS ( $this->getDbConfig (), $this->message, $_REQUEST,$_SERVER );
			exit();
		} catch ( Exception $e ) {
		
			echo  $e->getMessage ();
		}
	}
	public function getRequestBean(array $_data) {
		$person = null;
		$vehicleType = new VehicleType ();
		$phone = new Phone ();
		$address = new Address ();
		$vehicleTraveling = new VehicleTraveling ();
		$vehicleContact = new VehicleContact ();
		
		switch ($_data ["type_person"]) {
			case Person::PF :
				$person = new PersonIndividual ();
				$person->setName ( $_data ["vehicle_name"] );
				$person->setCpf ( $_data ["vehicle_cpf"] );
				break;
			case Person::PJ :
				$person = new PersonEntity ();
				$person->setName ( $_data ["vehicle_rsoc"] );
				$person->setContact ( $_data ["vehicle_contact"] );
				$person->setCnpj ( $_data ["vehicle_cnpj"] );
				
				break;
			default :
				$person = new Person ();
		}
		
		$vehicleType->setId ( $_data ["vehicle_type"] );
		
		$phone->setPhoneByMask ( $_data ["vehicle_phone"] );
		$person->setPhone ( $phone );
		
		$address->setCep ( $_data ["vehicle_zipcode"] );
		$address->setStreet ( $_data ["vehicle_address"] );
		$address->setNeighborhood ( $_data ["vehicle_neighborhood"] );
		$address->setNumber ( $_data ["vehicle_address_number"] );
		$address->setComplement ( $_data ["vehicle_complement"] );
		$address->setCity ( $_data ["vehicle_city"] );
		$address->setState ( $_data ["vehicle_region"] );

		$_ufs = $this->getListUf();		
		$address->setStateNm ( $_ufs[$_data ["vehicle_region"]] );		
		
		/*if ($address->getCep () != "" && ($address->getCity () == "" || $address->getState () == "")) {
			try {
				$addressDAO = AddressDAO::getInstance ();
				$db = DataBase::getInstance ( $addressDAO->loadDBConfigCep () );
				$addressDAO->getAddressByZipCode ( $db, $address );
				$db = null;
			} catch ( PDOException $e ) {
				$db = null;
			}
		}*/
		
		$person->setAddress ( $address );
		
		$vehicleContact->setPerson ( $person );
		$vehicleContact->setPhoneContact ( $phone );
		$vehicleContact->setName ( $person->getName () );
		$vehicleContact->setVehicleTraveling ( $vehicleTraveling );
		
		$vehicleTraveling->setVehicleType ( $vehicleType );
		$vehicleTraveling->setAddress ( $address );
		$vehicleTraveling->setPersonContact ( $vehicleContact );
		$vehicleTraveling->setIp ( Util::getClientIP () );
		
		return $vehicleTraveling;
	}
	public function getListUf(){
		$addressDAO = AddressDAO::getinstance( );
		$_result = array();
	
	
		$_result = $addressDAO->getListUf( );
	
		return $_result;
	
	}
	public function getTypeVechicles() {
		$this->vehicleTypeDAO = VehicleTypeDAO::getInstance ();
		$_result = array ();
		
		try {
			$criteria = new Criteria();
			$criteria->eq ( "vtyp.enabled", "1" );
			$db = DataBase::getInstance ( $this->getDbConfig ());
			$_result = $this->vehicleTypeDAO->getArrayCache ( $db , $criteria);
			// $db->commit ();
			$db = null;
			
			return $_result;
		} catch ( PDOException $e ) {
			
			/*
			 * if ($db->inTransaction()) $db->rollback ();
			 */
			$db = null;
			
			/*
			 * $this->message->setType ( Message::ERR ); $this->message->setDesc ( $e->getMessage () );
			 */
			
			return $_result;
		}
	}
	public function onSaveWeb() {
		$output = array (
				"result" => 0,
				"message" => "",
				"validationException" => array () 
		);
		$_validationException = array ();
		$inTransaction = false;
			
		try {			
			$vehicleTraveling = $this->getRequestBean ($_POST);
			$this->validateBean ( $vehicleTraveling );
			$excp = new ValidationException ( "Dados incompletos!" );
			
			//Validação Captcha
			if ($_POST ["vehicle_captcha"] == "")
				$excp->add ( "Código", "vehicle_captcha", "Código de segurança vazio!" );
			elseif ($_SESSION ["vehicle_captcha"] != $_POST ["vehicle_captcha"])
				$excp->add ( "Código", "vehicle_captcha", "Código de segurança inválido!" );			
			// conclusão
			if ($excp->size () > 0) {
				throw $excp;
			}
		
			$this->vehicleTravelingDAO = VehicleTravelingDAO::getInstance ();
			
			$db = DataBase::getInstance ( $this->getDbConfig () );
			$inTransaction = $db->beginTransaction ();
			$this->vehicleTravelingDAO->insert ( $db, $vehicleTraveling );
			$db->commit ();
			$db = null;
			
			$this->message->setType ( Message::SUCCESS );
			$this->message->setDesc ( "Registro " . $vehicleTraveling->getId () . " realizado com sucesso" );
		} catch ( ValidationException $e ) {
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$_validationException = $e->toArray ( true );
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		} catch ( PDOException $e ) {
			
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			if(eregi('cpf_UNIQUE', $e->getMessage()))
			{
				$newItem = array(
	    			"name" => htmlentities("CPF"),
	    			"id" => htmlentities("vehicle_cpf"),
	    			"message" => htmlentities("CPF já existente! Informe um outro"),
	    		);
	    		$_validationException[] = $newItem;
				
			
				$this->message->setDesc ( "Dados inválidos!" );
			}else if(eregi('cnpj_UNIQUE', $e->getMessage()))
			{
				$newItem = array(
	    			"name" => htmlentities("CNPJ"),
	    			"id" => htmlentities("vehicle__cnpj"),
	    			"message" => htmlentities("CNPJ já existente! Informe um outro"),
	    		);
	    		$_validationException[] = $newItem;
				
			
				$this->message->setDesc ( "Dados inválidos!" );
			}else{
				$this->message->setDesc ( $e->getMessage () );
			}
		} catch ( Exception $e ) {
			if ($db!=null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		}
		
		$output ["result"] = $this->message->getType ();
		$output ["message"] = iconv ( "ISO-8859-1", "UTF-8", str_replace("\\n","<br/>",$this->message->getDesc () ));
		$output ["validationException"] = $_validationException;
		
		header ( "Content-type: text/plain" );
		echo json_encode ( $output );
		exit ();
	}
	public function validateBean(VehicleTraveling $obj) {
		$e = new ValidationException ( "Dados incompletos!" );
		
		$vehicleContact = $obj->getPersonContact ();
		$address = $obj->getAddress ();
		$phone = $vehicleContact->getPhoneContact ();
		$person = $vehicleContact->getPerson ();
		$vehicleType = $obj->getVehicleType ();
		
		if ($person->getType () == Person::PJ) {
			if ($person->getCNPJ () == "") {
				$e->add ( "CNPJ", "vehicle_cnpj", "CNPJ vazio!" );
			} else if (! Validation::isCNPJ ( $person->getCNPJ () )) {
				$e->add ( "CNPJ", "vehicle_cnpj", "CNPJ inválido!" );
			}
			
			if ($person->getName () == "") {
				$e->add ( "Razão Social", "vehicle_rsoc", "Razão Social vazia!" );
			}
			
			if ($person->getContact () == "") {
				$e->add ( "Contato", "vehicle_contact", "Contato vazio!" );
			}
		} elseif ($person->getType () == Person::PF) {
			if ($person->getCPF () == "") {
				$e->add ( "CPF", "vehicle_cpf", "CPF vazio!" );
			} else if (! Validation::isCPF ( $person->getCPF () )) {
				$e->add ( "CPF", "vehicle_cpf", "CPF inválido" );
			}
			
			if ($person->getName () == "") {
				$e->add ( "Nome", "vehicle_name", "Nome vazio!" );
			}
		}
		
		if ($vehicleType->getId () <= 0) {
			$e->add ( "Tipo de Veículo", "vehicle_type", "Tipo de Veículo vazio!" );
		}
		
		$_vechicleTypes = $this->getTypeVechicles();
		$exist = false;
		foreach ($_vechicleTypes AS $vechicleTypesLoop){
			if($vehicleType->getId () == $vechicleTypesLoop->getId()){
				$exist = true;
				break;
			}
		}
		if(!$exist){
			$e->add ( "Tipo de Veículo", "vehicle_type", "Tipo de Veículo ".$vehicleType->getId ()." inválido!" );
		}
		
		if ($phone->getPhone () == "") {
			$e->add ( "Telefone", "vehicle_phone", "Telefone vazio!" );
		}
		
		if ($address->getCep () == "") {
			$e->add ( "CEP", "vehicle_zipcode", "CEP vazio!" );
		}
		
		if(strlen($address->getCep ()) != 8){
			$e->add ( "CEP", "vehicle_zipcode", "CEP ".$address->getCep ()." inválido");
		}
		
		if($obj->getSource() != VehicleTraveling::SOURCE_SMS )
		{				
			
			if ($address->getCity () == "") {
				$e->add ( "Cidade", "vehicle_city", "Cidade inválida!" );
			} 
			
			if ($address->getState () == "") {
				$e->add ( "UF", "vehicle_region", "UF inválida!" );
			}			
		}
		// conclusão
		if ($e->size () > 0) {
			
			throw $e;
		}
	}
	public function getImageCaptcha() {
		$dir = dirname ( dirname ( dirname ( __FILE__ ) ) );
		$codigoCaptcha = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789"),0,4);
		
		$_SESSION ["vehicle_captcha"] = $codigoCaptcha;
		
		$imagemCaptcha = imagecreatefrompng ( $dir . "/images/fundocaptch.png" );
		
		$fonteCaptcha = imageloadfont ( $dir . "/images/anonymous.gdf" );
		
		$corCaptcha = imagecolorallocate ( $imagemCaptcha, 205, 0, 0 );
		
		
		imagestring ( $imagemCaptcha, $fonteCaptcha, 15, 5, $_SESSION ["vehicle_captcha"], $corCaptcha );
		
		header ( "Content-type: image/png" );
		
		imagepng ( $imagemCaptcha );
		
		imagedestroy ( $imagemCaptcha );
	}
}

$ctrlVehReg = new VehicleRegCtrl ();
?>
