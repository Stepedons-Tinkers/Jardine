<?php
include_once('include/custom_workflows/Members.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activateMember(){
	global $current_user;

	$currentModule = 'Members';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	$currentModule_rel = 'MembershipStatusLogs';
    $record_rel = '';
    $focus_rel = CRMEntity::getInstance($currentModule_rel);
	$focus_rel->column_fields['z_msl_memberid'] = $record;
	$focus_rel->column_fields['z_msl_statusfrom'] = $focus->column_fields['z_m_membershipstatus'];
	$focus_rel->column_fields['z_msl_statusto'] = 'Active';	
	$focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membersStatus_Activate($focus);
	membersStatus_ActivationDate($focus);
	insertMembershipStatusLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=Members&record=$record");
}

function setInactiveMember(){
	global $current_user;

	$currentModule = 'Members';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	$currentModule_rel = 'MembershipStatusLogs';
    $record_rel = '';
    $focus_rel = CRMEntity::getInstance($currentModule_rel);
	$focus_rel->column_fields['z_msl_memberid'] = $record;
	$focus_rel->column_fields['z_msl_statusfrom'] = $focus->column_fields['z_m_membershipstatus'];
	$focus_rel->column_fields['z_msl_statusto'] = 'Inactive';	
	$focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membersStatus_SetInactive($focus);
	insertMembershipStatusLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=Members&record=$record");
}

function deactivateMember(){
	global $current_user;

	$currentModule = 'Members';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	$currentModule_rel = 'MembershipStatusLogs';
    $record_rel = '';
    $focus_rel = CRMEntity::getInstance($currentModule_rel);
	$focus_rel->column_fields['z_msl_memberid'] = $record;
	$focus_rel->column_fields['z_msl_statusfrom'] = $focus->column_fields['z_m_membershipstatus'];
	$focus_rel->column_fields['z_msl_statusto'] = 'Deactivated';	
	$focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membersStatus_Deactivate($focus);
	insertMembershipStatusLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=Members&record=$record");
}


?>