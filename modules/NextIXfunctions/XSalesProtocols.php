<?php
include_once('include/custom_workflows/XSalesProtocols.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XSalesProtocols';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateSalesProtocols($focus);
	
	header("Location: index.php?action=DetailView&module=XSalesProtocols&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XSalesProtocols';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateSalesProtocols($focus);
	
	header("Location: index.php?action=DetailView&module=XSalesProtocols&record=$record");
}


?>