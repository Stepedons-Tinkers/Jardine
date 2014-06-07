<?php
include_once('include/custom_workflows/XWorkplanEntry.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function approveToRegional(){
	global $current_user;

	$currentModule = 'XWorkplanEntry';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	approveToRegionalWorkplanEntry($focus);
	
	header("Location: index.php?action=DetailView&module=XWorkplanEntry&record=$record");
}

function approveToNSM(){
	global $current_user;

	$currentModule = 'XWorkplanEntry';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	approveToNSMWorkplanEntry($focus);
	
	header("Location: index.php?action=DetailView&module=XWorkplanEntry&record=$record");
}

?>