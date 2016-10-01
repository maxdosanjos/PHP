<?php
if ($viewExtCtrl == null){
	header("HTTP/1.0 404 Not Found");
	exit ();
}

require_once(dirname(dirname(__FILE__))."/shared/class/controller/VehicleQueryCtrl.class.php");
$ctrlVehQry->setTypeView(VehicleQueryCtrl::SEARCH_BY_ULT);

$_vechicleTypes   = $ctrlVehQry->getTypeVechicles();
$_ufList 		  = $ctrlVehQry->getListUf();
$ctrlVehQry->onSearchArray();
$_vehicleTrav 	  = $ctrlVehQry->getVehiclesTraveling();
$length 		  = count($_vehicleTrav);
$vehTravParam     = $ctrlVehQry->getVehTravParam();
$pagination 	  = $ctrlVehQry->getPagination();
$message    	  = $ctrlVehQry->getMessage();
$userSuper 	   	  = User::isUserSuper();

include_once("inc_busca_veiculo.php");
?>
