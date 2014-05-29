<?php
include_once('include/custom_workflows/XEventProtocol.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XEventProtocol';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateEventProtocol($focus);
	
	header("Location: index.php?action=DetailView&module=XEventProtocol&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XEventProtocol';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateEventProtocol($focus);
	
	header("Location: index.php?action=DetailView&module=XEventProtocol&record=$record");
}


?>