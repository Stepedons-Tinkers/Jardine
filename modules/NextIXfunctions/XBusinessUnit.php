<?php
include_once('include/custom_workflows/XBusinessUnit.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XBusinessUnit';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateBusinessUnit($focus);
	
	header("Location: index.php?action=DetailView&module=XBusinessUnit&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XBusinessUnit';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateBusinessUnit($focus);
	
	header("Location: index.php?action=DetailView&module=XBusinessUnit&record=$record");
}


?>