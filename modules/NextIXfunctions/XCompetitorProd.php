<?php
include_once('include/custom_workflows/XCompetitorProd.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XCompetitorProd';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateCompetitorProd($focus);
	
	header("Location: index.php?action=DetailView&module=XCompetitorProd&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XCompetitorProd';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateCompetitorProd($focus);
	
	header("Location: index.php?action=DetailView&module=XCompetitorProd&record=$record");
}


?>