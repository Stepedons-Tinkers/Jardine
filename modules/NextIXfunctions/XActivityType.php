<?php
include_once('include/custom_workflows/XActivityType.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XActivityType';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateActivityType($focus);
	
	header("Location: index.php?action=DetailView&module=XActivityType&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XActivityType';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateActivityType($focus);
	
	header("Location: index.php?action=DetailView&module=XActivityType&record=$record");
}


?>