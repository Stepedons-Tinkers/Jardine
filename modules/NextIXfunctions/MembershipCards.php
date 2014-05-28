<?php
include_once('include/custom_workflows/MembershipCards.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function issueToMember(){
	global $current_user;

	$currentModule = 'MembershipCards';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	// $currentModule_rel = 'MembershipCardLogs';
    // $record_rel = '';
    // $focus_rel = CRMEntity::getInstance($currentModule_rel);
	// $focus_rel->column_fields['z_mcl_membershipcardid'] = $record;
	// $focus_rel->column_fields['z_mcl_membershipcardnumber'] = $focus->column_fields['z_mc_membershipcardnumber'];
	// $focus_rel->column_fields['z_mcl_membershipcardstatus'] = 'Issued';	
	// $focus_rel->column_fields['z_mcl_version'] =  $focus->column_fields['z_mc_version'];	
	// $focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membershipCardStatus_Issued($focus);
	// insertMembershipCardLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=MembershipCards&record=$record");
}

function activateCard(){
	global $current_user;

	$currentModule = 'MembershipCards';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	// $currentModule_rel = 'MembershipCardLogs';
    // $record_rel = '';
    // $focus_rel = CRMEntity::getInstance($currentModule_rel);
	// $focus_rel->column_fields['z_mcl_membershipcardid'] = $record;
	// $focus_rel->column_fields['z_mcl_membershipcardnumber'] = $focus->column_fields['z_mc_membershipcardnumber'];
	// $focus_rel->column_fields['z_mcl_membershipcardstatus'] = 'Activated';	
	// $focus_rel->column_fields['z_mcl_version'] =  $focus->column_fields['z_mc_version'];	
	// $focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membershipCardStatus_Activated($focus);
	// insertMembershipCardLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=MembershipCards&record=$record");
}

function inactivateCard(){
	global $current_user;

	$currentModule = 'MembershipCards';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	// $currentModule_rel = 'MembershipCardLogs';
    // $record_rel = '';
    // $focus_rel = CRMEntity::getInstance($currentModule_rel);
	// $focus_rel->column_fields['z_mcl_membershipcardid'] = $record;
	// $focus_rel->column_fields['z_mcl_membershipcardnumber'] = $focus->column_fields['z_mc_membershipcardnumber'];
	// $focus_rel->column_fields['z_mcl_membershipcardstatus'] = 'Inactive';	
	// $focus_rel->column_fields['z_mcl_version'] =  $focus->column_fields['z_mc_version'];	
	// $focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membershipCardStatus_Inactive($focus);
	// insertMembershipCardLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=MembershipCards&record=$record");
}

function deactivateCard(){
	global $current_user;

	$currentModule = 'MembershipCards';
    $record = $_REQUEST['entityid'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;

	// $currentModule_rel = 'MembershipCardLogs';
    // $record_rel = '';
    // $focus_rel = CRMEntity::getInstance($currentModule_rel);
	// $focus_rel->column_fields['z_mcl_membershipcardid'] = $record;
	// $focus_rel->column_fields['z_mcl_membershipcardnumber'] = $focus->column_fields['z_mc_membershipcardnumber'];
	// $focus_rel->column_fields['z_mcl_membershipcardstatus'] = 'Deactivated';	
	// $focus_rel->column_fields['z_mcl_version'] =  $focus->column_fields['z_mc_version'];	
	// $focus_rel->column_fields['assigned_user_id'] = $current_user->id;		
	
	membershipCardStatus_Deactivated($focus);
	// insertMembershipCardLog($focus_rel);
	
	header("Location: index.php?action=DetailView&module=MembershipCards&record=$record");
}

function approveTierUpgrade(){

}

function disapproveTierUpgrade(){

}



?>