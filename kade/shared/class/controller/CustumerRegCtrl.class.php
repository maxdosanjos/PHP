<?
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/DateTimeCustom.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Util.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/util/Validation.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/mail/Mail.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PhoneVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/AddressVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonIndividualVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/PersonEntityVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/UserVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/ClientVO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/dao/ClientDAO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/dao/UserDAO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/dao/AddressDAO.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/exception/ValidationException.class.php");
require_once (dirname ( __FILE__ ) . "/AbstractCtrl.class.php");
class CustumerRegCtrl extends AbstractCtrl {
	private $clientDAO = null;
	private $clientEdit = null;
	public function __construct() {
		parent::__construct ();
		$this->setAction ( $_REQUEST ["action"] );
		
		switch ($this->getAction ()) {
			case "save" :
				$this->onSaveWeb ();
				break;
			case "saveInter" :
				$this->onSaveInter ();
				break;
			case "edit" :
				$this->onEdit ();
				break;
			case "getCaptcha" :
				$this->getImageCaptcha ();
				break;
			default :
		}
	}
	public function onEdit() {
		$this->clientEdit = null;
		
		$person = new Person();
		$person->setId ( $_GET ["custumer_person_id"] );
		try {
			if ($person==null || $person->getId() <= 0)
				throw new Exception ( "Cliente n�o encontrado!" );
			
			$criteria = new Criteria ();
			$criteria->eq ( "cli.user_person_id", $person->getId() );
			
			$this->clientDAO = ClientDAO::getInstance ();		
			$this->clientEdit = $this->clientDAO->getSingle ( $this->getDbConfig (), $criteria );
			if ($this->clientEdit == null || $this->clientEdit->getUser()->getPerson()->getId() <= 0)
				throw new Exception ( "Cliente n�o encontrado!" );
			
		} catch ( PDOException $e ) {
			$this->clientEdit = null;
		} catch ( Exception $e ) {
			$this->clientEdit = null;
		}
	}
	public function getClientEdit(){
		return $this->clientEdit;
	}
	public function getRequestBean(array $_data) {
		$client = new Client ();
		$person = null;
		$phone = new Phone ();
		$address = new Address ();
		
		switch ($_data ["type_person"]) {
			case Person::PF :
				$person = new PersonIndividual ();
				$person->setName ( $_data ["custumer_name"] );
				$person->setCpf ( $_data ["custumer_cpf"] );
				break;
			case Person::PJ :
				$person = new PersonEntity ();
				$person->setName ( $_data ["custumer_rsoc"] );
				$person->setContact ( $_data ["custumer_contact"] );
				$person->setCnpj ( $_data ["custumer_cnpj"] );
				
				if ($_data ["custumer_ie_isento"] == "on")
					$_data ["custumer_ie"] = PersonEntity::ISENTO;
				
				$person->setIe ( $_data ["custumer_ie"] );
				
				break;
			default :
				return $client;
		}
		
		$person->setEmail ( $_data ["custumer_mail"] );
		
		$phone->setPhoneByMask ( $_data ["custumer_phone"] );
		
		$phone->setId ( $_data ["custumer_phone_id"] );
		
		$person->setPhone ( $phone );
		
		$address->setCep ( $_data ["custumer_zipcode"] );
		$address->setStreet ( $_data ["custumer_address"] );
		$address->setNeighborhood ( $_data ["custumer_neighborhood"] );
		$address->setNumber ( $_data ["custumer_address_number"] );
		$address->setComplement ( $_data ["custumer_complement"] );
		$address->setCity ( $_data ["custumer_city"] );
		$address->setState ( $_data ["custumer_region"] );
		$_ufs = $this->getListUf ();
		$address->setStateNm ( $_ufs [$_data ["custumer_region"]] );
		
		/*
		 * if ($address->getCep () != "" && ($address->getCity () == "" || $address->getState () == "")) { try { $addressDAO = AddressDAO::getInstance (); $db = DataBase::getInstance ( $addressDAO->loadDBConfigCep () ); $addressDAO->getAddressByZipCode ( $db, $address ); $db = null; } catch ( PDOException $e ) { $db = null; } }
		 */
		
		$address->setId ( $_data ["custumer_address_id"] );
		$person->setAddress ( $address );
		
		$user = new User ();
		
		$person->setId ( $_data ["custumer_person_id"] );
		$user->setPerson ( $person );
		
		$user->setLogin ( $_data ["custumer_login"] );
		$user->setPassword ( $_data ["custumer_password"] );
		$user->setStatus ( User::PEND );
		
		if($_data ["custumer_status"]!=""){
			$user->setStatus ( $_data ["custumer_status"] );
		}
		
		if($_data["custumer_obs"]!="")
			$user->setText ( $_data["custumer_obs"] );
		
		$client->setUser ( $user );
		
		return $client;
	}
	public function validateBean(Client $obj, $validateLogin = true) {
		$e = new ValidationException ( "Dados incompletos!" );
		
		$user = $obj->getUser ();
		
		if ($user != null)
			$person = $user->getPerson ();
		
		if ($person != null) {
			$address = $person->getAddress ();
			$phone = $person->getPhone ();
			
			if ($person->getType () != "") {
				if ($person->getType () == Person::PJ) {
					if ($person->getCNPJ () == "") {
						$e->add ( "CNPJ", "custumer_cnpj", "CNPJ vazio!" );
					} else if (! Validation::isCNPJ ( $person->getCNPJ () )) {
						$e->add ( "CNPJ", "custumer_cnpj", "CNPJ inv�lido!" );
					}
					
					if ($person->getName () == "") {
						$e->add ( "Raz�o Social", "custumer_rsoc", "Raz�o Social vazia!" );
					}
					
					if ($person->getContact () == "") {
						$e->add ( "Contato", "custumer_contact", "Contato vazio!" );
					}
					
					if ($person->getIe () == "") {
						$e->add ( "I.E.", "custumer_ie", "Inscri��o Estadual vazio!" );
					}
				} elseif ($person->getType () == Person::PF) {
					if ($person->getCPF () == "") {
						$e->add ( "CPF", "custumer_cpf", "CPF vazio!" );
					} else if (! Validation::isCPF ( $person->getCPF () )) {
						$e->add ( "CPF", "custumer_cpf", "CPF inv�lido" );
					}
					
					if ($person->getName () == "") {
						$e->add ( "Nome", "custumer_name", "Nome vazio!" );
					}
				}
				
				if ($person->getEmail () == "") {
					$e->add ( "Email", "custumer_mail", "Email vazio!" );
				} elseif (! Validation::isEMail ( $person->getEmail () )) {
					$e->add ( "Email", "custumer_mail", "Email invalido!" );
				}
				
				if ($user != null) {
					if ($validateLogin) {
						if ($user->getLogin () == "") {
							$e->add ( "Login", "custumer_login", "Login vazio!" );
						} elseif (strlen ( $user->getLogin () ) < 5) {
							$e->add ( "Login", "custumer_login", "Login: N�mero de caracteres insuficiente! M�nimo = 5" );
						}
						
						if ($user->getPassword () == "") {
							$e->add ( "Senha", "custumer_password", "Senha vazia!" );
						} elseif (strlen ( $user->getPassword () ) < 5) {
							$e->add ( "Senha", "custumer_password", "Senha: N�mero de caracteres insuficiente! M�nimo = 5" );
						}
					}
					if ($phone != null) {
						if ($phone->getPhone () == "") {
							$e->add ( "Telefone", "custumer_phone", "Telefone vazio!" );
						}
						
						if ($address != null) {
							if ($address->getCep () == "" || strlen ( $address->getCep () ) < 8) {
								$e->add ( "CEP", "custumer_zipcode", "CEP vazio!" );
							}
							if ($address->getCity () == "") {
								$e->add ( "Cidade", "custumer_city", "Cidade inv�lida!" );
							}
							if ($address->getState () == "") {
								$e->add ( "UF", "custumer_region", "UF inv�lida!" );
							}
							
							if ($address->getNumber () == "") {
								$e->add ( "N�mero", "custumer_address_number", "N�mero vazio!" );
							}
						} else
							$e->add ( "CEP", "custumer_zipcode", "Necess�rio os dados obrigat�rios" );
					} else
						$e->add ( "Telefone", "custumer_phone", "Necess�rio os dados obrigat�rios" );
				} else
					$e->add ( "Login", "custumer_login", "Necess�rio os dados obrigat�rios" );
			} else
				$e->add ( "Tipo de Pessoa", "type_person", "Necess�rio o tipo de Pessoa" );
		} else
			$e->add ( "Tipo de Pessoa", "type_person", "Necess�rio os dados obrigat�rios" );
			
			// conclus�o
		if ($e->size () > 0) {
			throw $e;
		}
	}
	private function sendMailConfirm($dbConfig, Client $custumer) {
		$md5 = md5 ( date ( "dmYHis" . microtime () ) );
		
		$url = $_SERVER ["HTTP_HOST"] . "/confirm_user/vua=" . $md5;
		if (! eregi ( "http://", $url ))
			$url = "http://" . $url;
		
		$userDAO = UserDAO::getInstance ();
		$userDAO->registerLinkConfirm ( $dbConfig, $custumer->getUser (), $md5 );
		
		$mail = new Mail ();
		ob_start ();
		include_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) . "/view/model_mail_cad_cli.php");
		$content = ob_get_contents ();
		ob_end_clean ();
		
		$person = $custumer->getUser ()->getPerson ();
		
		$subject = "Confirma��o de usu�rio KADE Caminh�es";
		$from = new EmailAddress ( 'contato@kadecaminhoes.com.br', 'Contato KADE Caminh�es' );
		$to [] = new EmailAddress ( $person->getEmail (), $person->getName () );
		
		$mail->sendPHPMail ( $from, $to, $subject, $content, "text/html", array (), array (), true );
	}
	public function onSaveInter() {
		$output = array (
				"result" => 0,
				"message" => "",
				"validationException" => array () 
		);
		
		$_validationException = array ();
		$inTransaction = false;
		
		try {
			$custumer = $this->getRequestBean ( $_POST );
			
			if(User::isUserSuper() && $custumer->getUser()->getPerson()->getId()!= User::getLogged()->getPerson()->getId()){
				if($_POST ["custumer_captcha"] == "")
					$_POST ["custumer_captcha"] = $_SESSION ["custumer_captcha"];
			}
			
			$this->validateBean ( $custumer, false );
			$excp = new ValidationException ( "Dados incompletos!" );
			
			// Valida��o Captcha
			if ($_POST ["custumer_captcha"] == "")
				$excp->add ( "C�digo", "custumer_captcha", "C�digo de seguran�a vazio!" );
			elseif ($_SESSION ["custumer_captcha"] != $_POST ["custumer_captcha"])
				$excp->add ( "C�digo", "custumer_captcha", "C�digo de seguran�a inv�lido!" );
				// conclus�o
			if ($excp->size () > 0) {
				throw $excp;
			}
			
			$this->clientDAO = ClientDAO::getInstance ();
			
			$db = DataBase::getInstance ( $this->getDbConfig () );
			$inTransaction = $db->beginTransaction ();
			$this->clientDAO->update ( $db, $custumer );
			
			$userLogged = User::getLogged ();
			
			if ($userLogged != null && $custumer->getUser ()->getPerson ()->getId () == $userLogged->getPerson ()->getId ()) {
				$criteria = new Criteria ();
				$criteria->eq ( "usr.person_id", $userLogged->getPerson ()->getId () );
				$userDAO = UserDAO::getInstance ();
				$userLogged = $userDAO->getSingle ( $db, $criteria );
				if ($userLogged == null || ($userLogged != null && $userLogged->getLogin () == ""))
					throw new Exception ( "Usu�rio inv�lido!!" );
				
				$_SESSION ["user"] = serialize ( $userLogged );
			}
			
			$db->commit ();
			$db = null;
			
			$this->message->setType ( Message::SUCCESS );
			$this->message->setDesc ( "Cadastro atualizado com sucesso!" );
		} catch ( ValidationException $e ) {
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$_validationException = $e->toArray ( true );
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		} catch ( PDOException $e ) {
			
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			if (eregi ( 'login_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "Login" ),
						"id" => htmlentities ( "custumer_login" ),
						"message" => htmlentities ( "Login j� existente! Informe um outro" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else if (eregi ( 'cpf_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "CPF" ),
						"id" => htmlentities ( "custumer_cpf" ),
						"message" => htmlentities ( "CPF j� utilizado!" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else if (eregi ( 'cnpj_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "CNPJ" ),
						"id" => htmlentities ( "custumer_cnpj" ),
						"message" => htmlentities ( "CNPJ j� utilizado!" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else {
				$this->message->setDesc ( $e->getMessage () );
			}
		} catch ( Exception $e ) {
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		}
		
		$output ["result"] = $this->message->getType ();
		$output ["message"] = iconv ( "ISO-8859-1", "UTF-8", str_replace ( "\\n", "<br/>", $this->message->getDesc () ) );
		$output ["validationException"] = $_validationException;
		
		header ( "Content-type: text/plain" );
		echo json_encode ( $output );
		exit ();
		
		// $output ["result"] = $this->message->getType ();
		/*
		 * $output ["result"] = "error"; $output ["message"] = iconv ( "ISO-8859-1", "UTF-8", str_replace("\\n","<br/>","Tente mais tarde" )); $output ["validationException"] = $_validationException; header ( "Content-type: text/plain" ); echo json_encode ( $output ); exit ();
		 */
	}
	public function getListUf() {
		$addressDAO = AddressDAO::getinstance ();
		$_result = array ();
		
		$_result = $addressDAO->getListUf ();
		
		return $_result;
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
			$custumer = $this->getRequestBean ( $_POST );
			$this->validateBean ( $custumer );
			$excp = new ValidationException ( "Dados incompletos!" );
			
			// Valida��o Captcha
			if ($_POST ["custumer_captcha"] == "")
				$excp->add ( "C�digo", "custumer_captcha", "C�digo de seguran�a vazio!" );
			elseif ($_SESSION ["custumer_captcha"] != $_POST ["custumer_captcha"])
				$excp->add ( "C�digo", "custumer_captcha", "C�digo de seguran�a inv�lido!" );
				// conclus�o
			if ($excp->size () > 0) {
				throw $excp;
			}
			
			$this->clientDAO = ClientDAO::getInstance ();
			
			$db = DataBase::getInstance ( $this->getDbConfig () );
			$inTransaction = $db->beginTransaction ();
			$this->clientDAO->insert ( $db, $custumer );
			
			$this->sendMailConfirm ( $db, $custumer );
			
			$db->commit ();
			$db = null;
			
			$person = $custumer->getUser ()->getPerson ();
			$this->message->setType ( Message::SUCCESS );
			$this->message->setDesc ( "Cadastro realizado com sucesso! Para confirmar o cadastro acesse o email " . $person->getEmail () . "  e clique no link solicitado  " );
		} catch ( ValidationException $e ) {
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$_validationException = $e->toArray ( true );
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		} catch ( PDOException $e ) {
			
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			if (eregi ( 'login_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "Login" ),
						"id" => htmlentities ( "custumer_login" ),
						"message" => htmlentities ( "Login j� existente! Informe um outro" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else if (eregi ( 'cpf_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "CPF" ),
						"id" => htmlentities ( "custumer_cpf" ),
						"message" => htmlentities ( "CPF j� utilizado!" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else if (eregi ( 'cnpj_UNIQUE', $e->getMessage () )) {
				$newItem = array (
						"name" => htmlentities ( "CNPJ" ),
						"id" => htmlentities ( "custumer_cnpj" ),
						"message" => htmlentities ( "CNPJ j� utilizado!" ) 
				);
				$_validationException [] = $newItem;
				
				$this->message->setDesc ( "Dados inv�lidos!" );
			} else {
				$this->message->setDesc ( $e->getMessage () );
			}
		} catch ( Exception $e ) {
			if ($db != null && $inTransaction)
				$db->rollback ();
			$db = null;
			
			$this->message->setType ( Message::ERR );
			$this->message->setDesc ( $e->getMessage () );
		}
		
		$output ["result"] = $this->message->getType ();
		$output ["message"] = iconv ( "ISO-8859-1", "UTF-8", str_replace ( "\\n", "<br/>", $this->message->getDesc () ) );
		$output ["validationException"] = $_validationException;
		
		header ( "Content-type: text/plain" );
		echo json_encode ( $output );
		exit ();
		
		// $output ["result"] = $this->message->getType ();
		/*
		 * $output ["result"] = "error"; $output ["message"] = iconv ( "ISO-8859-1", "UTF-8", str_replace("\\n","<br/>","Tente mais tarde" )); $output ["validationException"] = $_validationException; header ( "Content-type: text/plain" ); echo json_encode ( $output ); exit ();
		 */
	}
	public function getImageCaptcha() {
		$dir = dirname ( dirname ( dirname ( __FILE__ ) ) );
		$codigoCaptcha = substr ( str_shuffle ( "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789" ), 0, 4 );
		
		$_SESSION ["custumer_captcha"] = $codigoCaptcha;
		
		$imagemCaptcha = imagecreatefrompng ( $dir . "/images/fundocaptch.png" );
		
		$fonteCaptcha = imageloadfont ( $dir . "/images/anonymous.gdf" );
		
		$corCaptcha = imagecolorallocate ( $imagemCaptcha, 205, 0, 0 );
		
		imagestring ( $imagemCaptcha, $fonteCaptcha, 15, 5, $_SESSION ["custumer_captcha"], $corCaptcha );
		
		header ( "Content-type: image/png" );
		
		imagepng ( $imagemCaptcha );
		
		imagedestroy ( $imagemCaptcha );
	}
}

$ctrlCustReg = new CustumerRegCtrl ();
