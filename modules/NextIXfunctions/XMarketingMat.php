<?php
include_once('include/custom_workflows/XMarketingMat.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activate(){
	global $current_user;

	$currentModule = 'XMarketingMat';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	activateMarketingMat($focus);
	
	header("Location: index.php?action=DetailView&module=XMarketingMat&record=$record");
}

function deactivate(){
	global $current_user;

	$currentModule = 'XMarketingMat';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = "x".$record;

	deactivateMarketingMat($focus);
	
	header("Location: index.php?action=DetailView&module=XMarketingMat&record=$record");
}


?>