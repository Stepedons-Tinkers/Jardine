<?php
include_once('include/custom_workflows/XCompetitor.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XCompetitor';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateCompetitor($focus);
	
	header("Location: index.php?action=DetailView&module=XCompetitor&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XCompetitor';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateCompetitor($focus);
	
	header("Location: index.php?action=DetailView&module=XCompetitor&record=$record");
}


?>