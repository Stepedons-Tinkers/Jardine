<?php
include_once('include/custom_workflows/Rewards.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function activateReward(){

	$currentModule = 'Rewards';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$currentModule_RL = 'RewardLogs';
    $focus_RL = CRMEntity::getInstance($currentModule_RL);
	$focus_RL->column_fields['z_rwl_reward_id'] = $record;
	$focus_RL->column_fields['z_rwl_reward_name'] = $focus->column_fields['z_rw_reward_name'];
	$focus_RL->column_fields['z_rwl_program_id'] = $focus->column_fields['z_rw_program_id'];
	$focus_RL->column_fields['z_rwl_statusfrom'] = $focus->column_fields['z_rw_status'];
	$focus_RL->column_fields['z_rwl_statusto'] = 'Activate';
	$focus_RL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	reward_Activated($focus);
	insertRewardLog($focus_RL);
	
	header("Location: index.php?action=DetailView&module=Rewards&record=$record");
}

function deactivateReward(){

	$currentModule = 'Rewards';
    $record = $_REQUEST['record'];
    
    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$currentModule_RL = 'RewardLogs';
    $focus_RL = CRMEntity::getInstance($currentModule_RL);
	$focus_RL->column_fields['z_rwl_reward_id'] = $record;
	$focus_RL->column_fields['z_rwl_reward_name'] = $focus->column_fields['z_rw_reward_name'];
	$focus_RL->column_fields['z_rwl_program_id'] = $focus->column_fields['z_rw_program_id'];
	$focus_RL->column_fields['z_rwl_statusfrom'] = $focus->column_fields['z_rw_status'];
	$focus_RL->column_fields['z_rwl_statusto'] = 'Deactivated';
	$focus_RL->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
	
	
	reward_Deactivated($focus);
	insertRewardLog($focus_RL);
	
	header("Location: index.php?action=DetailView&module=Rewards&record=$record");
}


?>