<?php
include_once('include/custom_workflows/XSupplier.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XSupplier';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateSupplier($focus);
	
	header("Location: index.php?action=DetailView&module=XSupplier&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XSupplier';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateSupplier($focus);
	
	header("Location: index.php?action=DetailView&module=XSupplier&record=$record");
}


?>