<?php
include_once('include/custom_workflows/XCCPerson.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XCCPerson';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateCCPerson($focus);
	
	header("Location: index.php?action=DetailView&module=XCCPerson&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XCCPerson';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateCCPerson($focus);
	
	header("Location: index.php?action=DetailView&module=XCCPerson&record=$record");
}


?>