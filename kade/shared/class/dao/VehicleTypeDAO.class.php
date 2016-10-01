<?php
require_once (dirname ( __FILE__ ) . "/DBConfig.class.php");
require_once (dirname ( __FILE__ ) . "/DataBase.class.php");
require_once (dirname ( __FILE__ ) . "/Criteria.class.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/vo/VehicleTypeVO.class.php");
class VehicleTypeDAO {
	private static $res = null;
	private function __construct() {
	}
	public static function getInstance() {
		if (self::$res == null)
			self::$res = new self ();
		return self::$res;
	}
	public function getArray($dbConfig, Criteria $criteria = null) {
		$sql = "
			    SELECT 	  vtyp.id
					   	, vtyp.descr
						, vtyp.enabled
				  FROM 	vehicle_type vtyp
				";
		
		//if ($criteria == null)
		//	$criteria = new Criteria ();
		
		//$criteria->eq ( "vtyp.enabled", "1" );
		if ($criteria != null) {
			$sql .= $criteria->getWHERE ();
			$sql .= $criteria->getORDER ();
			$sql .= $criteria->getLIMIT ();
		}
		
		if ($dbConfig instanceof DBConfig)
			$db = DataBase::getInstance ( $dbConfig );
		else if ($dbConfig instanceof DataBase)
			$db = $dbConfig;
		else
			throw new PDOException ( "Conex�o inv�lida" );
		
		$result = $db->query ( $sql );
		
		if ($dbConfig instanceof DBConfig)
			$db = null;
		
		$_arr = array ();
		
		while ( $objDAO = $result->fetchObject () ) {
			$vechicleType = new VehicleType ();
			$vechicleType->setId ( $objDAO->id );
			$vechicleType->setDescr ( $objDAO->descr );
			$vechicleType->setEnabled ( $objDAO->enabled );
			$_arr [] = $vechicleType;
		}
		return $_arr;
	}
	public function count($dbConfig, Criteria $criteria = null) {
		$sql = "
			    SELECT 	COUNT(vtyp.id) AS total
				  FROM 	vehicle_type vtyp
				";
	
		//if ($criteria == null)
		//	$criteria = new Criteria ();
	
		//$criteria->eq ( "vtyp.enabled", "1" );
		if ($criteria != null) {
			$sql .= $criteria->getWHERE ();
			$sql .= $criteria->getORDER ();
			$sql .= $criteria->getLIMIT ();
		}
	
		if ($dbConfig instanceof DBConfig)
			$db = DataBase::getInstance ( $dbConfig );
		else if ($dbConfig instanceof DataBase)
			$db = $dbConfig;
		else
			throw new PDOException ( "Conex�o inv�lida" );
	
		$result = $db->query ( $sql );
	
		if ($dbConfig instanceof DBConfig)
			$db = null;	
		
		$objDAO = $result->fetchObject ();
		
		if($objDAO->total > 0)
			return $objDAO->total;
		return 0; 
	}
	public function getArrayCache($dbConfig) {
		//$_SESSION ["list_vehicle_type"] = "";
		if($_SESSION ["list_vehicle_type"]!=""){
			$_result = unserialize ( $_SESSION ["list_vehicle_type"] );
		}
		
		if (sizeof ( $_result ) > 0) {
			return $_result;
		} else {
			$_result = array ();
			
			try {
				$_result = $this->getArray ( $dbConfig );
				$_SESSION["list_vehicle_type"] = serialize($_result);
			} catch ( PDOException $e ) {
				throw $e;
			}
		}
		
		if (sizeof ( $_result ) <= 0)
			$_result = array ();
		
		return $_result;
	}
}
?>