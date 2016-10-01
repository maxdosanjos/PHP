<?php
if ($viewExtCtrl == null){
	header("HTTP/1.0 404 Not Found");
	exit ();
}

require_once(dirname(dirname(__FILE__))."/shared/class/controller/VehicleQueryCtrl.class.php");
$ctrlVehQry->setTypeView(VehicleQueryCtrl::REG_CREATED);

$_vechicleTypes   = $ctrlVehQry->getTypeVechicles();
$_ufList 		  = $ctrlVehQry->getListUf();
$ctrlVehQry->onSearchArray();
$_vehicleTrav 	  = $ctrlVehQry->getVehiclesTraveling();
$length 		  = count($_vehicleTrav);
$vehTravParam     = $ctrlVehQry->getVehTravParam();
$pagination 	  = $ctrlVehQry->getPagination();
$message    	  = $ctrlVehQry->getMessage();

include_once("inc_busca_veiculo.php");
?>
