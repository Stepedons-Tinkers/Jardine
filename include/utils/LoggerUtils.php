<?php
function getCarID($carid){
	require_once ("modules/HomeOwner/HomeOwner.php");
	global $adb;
	$result = $adb->pquery("select * from vtiger_cars
				inner join vtiger_crmentity on vtiger_cars.carsid = vtiger_crmentity.crmid
				where deleted = 0 and plate_no = ?",array($carid));
	$num_rows = $adb->num_rows($result);
	
	
	if($num_rows > 0){
		$focus = CRMEntity::getInstance('HomeOwner');
		$focus->id = $adb->query_result($result,0,'homeowner');
		$focus->retrieve_entity_info($focus->id, 'HomeOwner');
		return $focus;
	}else{
		return false;
	}
}
?>