<?php
include_once('include/custom_workflows/XCustomers.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XCustomers';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateCustomers($focus);
	
	header("Location: index.php?action=DetailView&module=XCustomers&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XCustomers';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateCustomers($focus);
	
	header("Location: index.php?action=DetailView&module=XCustomers&record=$record");
}

function approve(){
	global $current_user;

	$currentModule = 'XCustomers';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	approveCustomers($focus);
	
	header("Location: index.php?action=DetailView&module=XCustomers&record=$record");
}


?>