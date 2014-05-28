<?php
include_once('include/custom_workflows/ProgramTiers.php');
include_once('include/nextixlib/ModulesDeleteMethod.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activateProgramTier(){

	$currentModule = 'ProgramTiers';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$currentModule_PTL = 'ProgramTierLogs';
    $focus_PTL = CRMEntity::getInstance($currentModule_PTL);
	$focus_PTL->column_fields['z_ptl_programtier_id'] = $record;
	$focus_PTL->column_fields['z_ptl_field_name'] = 'Status';
	$focus_PTL->column_fields['z_ptl_from_value'] = $focus->column_fields['z_pt_status'];
	$focus_PTL->column_fields['z_ptl_to_value'] = 'Active';
	$focus_PTL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	programTier_Activated($focus);
	// insertPogramTierLog($focus_PTL);
	
	header("Location: index.php?action=DetailView&module=ProgramTiers&record=$record");
}

function deactivateProgramTier(){
	
	$modulesDeleteMethod = new ModulesDeleteMethod();
	
	$currentModule = 'ProgramTiers';
	$record = $_REQUEST['record'];
	
	$modulesDeleteMethod->setData($currentModule,'','',$record,'');
	$modulesDeleteMethod->checkDelete_CascadeDeactivate();
	$modulesDeleteMethod->CascadeDeactivate();
	
	// $currentModule = 'ProgramTiers';
    // $record = $_REQUEST['record'];
    
    // $focus = CRMEntity::getInstance($currentModule);
    // $focus->retrieve_entity_info($record, $currentModule);
    // $focus->id  = $record;
	
	// $currentModule_PTL = 'ProgramTierLogs';
    // $focus_PTL = CRMEntity::getInstance($currentModule_PTL);
	// $focus_PTL->column_fields['z_ptl_programtier_id'] = $record;
	// $focus_PTL->column_fields['z_ptl_field_name'] = 'Status';
	// $focus_PTL->column_fields['z_ptl_from_value'] = $focus->column_fields['z_pt_status'];
	// $focus_PTL->column_fields['z_ptl_to_value'] = 'Deactivated';
	// $focus_PTL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	// programTier_Deactivated($focus);
	// insertPogramTierLog($focus_PTL);
	
	header("Location: index.php?action=DetailView&module=ProgramTiers&record=$record");
}


?>