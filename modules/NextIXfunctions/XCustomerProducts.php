<?php
include_once('include/custom_workflows/XCustomerProducts.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XCustomerProducts';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateCustomerProducts($focus);
	
	header("Location: index.php?action=DetailView&module=XCustomerProducts&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XCustomerProducts';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateCustomerProducts($focus);
	
	header("Location: index.php?action=DetailView&module=XCustomerProducts&record=$record");
}


?>