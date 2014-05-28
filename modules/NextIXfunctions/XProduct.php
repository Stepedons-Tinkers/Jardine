<?php
include_once('include/custom_workflows/XProduct.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XProduct';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateProduct($focus);
	
	header("Location: index.php?action=DetailView&module=XProduct&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XProduct';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateProduct($focus);
	
	header("Location: index.php?action=DetailView&module=XProduct&record=$record");
}


?>