<?php
include_once('include/custom_workflows/XSMR.php');
echo "bbb";
$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	echo "vvv";
	global $current_user;

	$currentModule = 'XSMR';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateSMR($focus);
	
	header("Location: index.php?action=DetailView&module=XSMR&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XSMR';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateSMR($focus);
	
	header("Location: index.php?action=DetailView&module=XSMR&record=$record");
}


?>