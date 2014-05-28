<?php
include_once('include/custom_workflows/Privileges.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activatePrivilege(){

	$currentModule = 'Privileges';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$currentModule_PL = 'PrivilegeLogs';
	$focus_PL = CRMEntity::getInstance($currentModule_PL);
	$focus_PL->column_fields['z_pvl_privilege_id'] = $record;
	$focus_PL->column_fields['z_pvl_privilege_name'] = $focus->column_fields['z_pv_privilege_name'];
	$focus_PL->column_fields['z_pvl_program_id'] = $focus->column_fields['z_pv_program_id'];
	$focus_PL->column_fields['z_pvl_statusfrom'] = $focus->column_fields['z_pv_status'];
	$focus_PL->column_fields['z_pvl_statusto'] = 'Activate';
	$focus_PL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	privilege_Activated($focus);
	insertPrivilegeLog($focus_PL);
	
	header("Location: index.php?action=DetailView&module=Privileges&record=$record");
}

function deactivatePrivilege(){

	$currentModule = 'Privileges';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$currentModule_PL = 'PrivilegeLogs';
    $focus_PL = CRMEntity::getInstance($currentModule_PL);
	$focus_PL->column_fields['z_pvl_privilege_id'] = $record;
	$focus_PL->column_fields['z_pvl_privilege_name'] = $focus->column_fields['z_pv_privilege_name'];
	$focus_PL->column_fields['z_pvl_program_id'] = $focus->column_fields['z_pv_program_id'];
	$focus_PL->column_fields['z_pvl_statusfrom'] = $focus->column_fields['z_pv_status'];
	$focus_PL->column_fields['z_pvl_statusto'] = 'Deactivated';
	$focus_PL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	privilege_Deactivated($focus);
	insertPrivilegeLog($focus_PL);
	
	header("Location: index.php?action=DetailView&module=Privileges&record=$record");
}


?>