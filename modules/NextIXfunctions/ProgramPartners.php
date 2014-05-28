<?php
include_once('include/custom_workflows/ProgramPartners.php');
include_once('include/nextixlib/ModulesDeleteMethod.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activateProgramPartner(){

	$currentModule = 'ProgramPartners';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	// $currentModule_PTL = 'ProgramPartnerLogs';
    // $focus_PPL = CRMEntity::getInstance($currentModule_PTL);
	// $focus_PPL->column_fields['z_ppl_progpartner_id'] = $record;
	// $focus_PPL->column_fields['z_ppl_org_name'] = $focus->column_fields['z_pp_org_name'];
	// $focus_PPL->column_fields['z_ppl_program_id'] = $focus->column_fields['z_pp_program_id'];
	// $focus_PPL->column_fields['z_ppl_statusfrom'] = $focus->column_fields['z_pp_status'];
	// $focus_PPL->column_fields['z_ppl_statusto'] = 'Activate';
	// $focus_PPL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	programPartner_Activated($focus);
	// insertPogramPartnerLog($focus_PPL);
	
	header("Location: index.php?action=DetailView&module=ProgramPartners&record=$record");
}

function deactivateProgramPartner(){

	$currentModule = 'ProgramPartners';
    $record = $_REQUEST['record'];
    
	$modulesDeleteMethod = new ModulesDeleteMethod();
	$modulesDeleteMethod->setData($currentModule,'','',$record,'');
	$modulesDeleteMethod->checkDelete_CascadeDeactivate();
	$modulesDeleteMethod->CascadeDeactivate();	
	
    // $focus = CRMEntity::getInstance($currentModule);
    // $focus->retrieve_entity_info($record, $currentModule);
    // $focus->id  = $record;
	
	// $currentModule_PTL = 'ProgramPartnerLogs';
    // $focus_PPL = CRMEntity::getInstance($currentModule_PTL);
	// $focus_PPL->column_fields['z_ppl_progpartner_id'] = $record;
	// $focus_PPL->column_fields['z_ppl_org_name'] = $focus->column_fields['z_pp_org_name'];
	// $focus_PPL->column_fields['z_ppl_program_id'] = $focus->column_fields['z_pp_program_id'];
	// $focus_PPL->column_fields['z_ppl_statusfrom'] = $focus->column_fields['z_pp_status'];
	// $focus_PPL->column_fields['z_ppl_statusto'] = 'Deactivated';
	// $focus_PPL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	// programPartner_Deactivated($focus);
	// insertPogramPartnerLog($focus_PPL);
	
	header("Location: index.php?action=DetailView&module=ProgramPartners&record=$record");
}


?>