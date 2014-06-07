<?php
include_once('include/custom_workflows/XWorkplanEntry.php');

$function = $_REQUEST['functionNextIX'];
$function();	

function approveToRegional(){
	global $current_user;
	
	$workplanid = $_REQUEST['entityid'];
	$workplanentries_detail = getWorkplanEntriesDetail(array($_REQUEST['entityid']));
	
	foreach($workplanentries_detail[$_REQUEST['entityid']] as $workplanentryid => $workplanentryval){
		if($workplanentryval['z_wpe_status'] == 'Pending For Approval'){
			$currentModule = 'XWorkplanEntry';
			$record = $workplanentryval['xworkplanentryid'];
			
			$focus = CRMEntity::getInstance($currentModule);
			$focus->retrieve_entity_info($record, $currentModule);
			$focus->id  = "x".$record;

			approveToRegionalWorkplanEntry($focus);
		}
	}
	
	header("Location: index.php?action=DetailView&module=XWorkplan&record=$workplanid");
}

function approveToNSM(){
	global $current_user;
	$workplanid = $_REQUEST['entityid'];
	$workplanentries_detail = getWorkplanEntriesDetail(array($_REQUEST['entityid']));
	$assignedtouser_role = '';
	$allowed_status = array();
	foreach($workplanentries_detail[$_REQUEST['entityid']] as $workplanentryid => $workplanentryval){
		if($assignedtouser_role == ''){
			$assignedtouser_detail = getUserDetails_id(array($workplanentryval['smownerid']));
			$assignedtouser_role = $assignedtouser_detail[$workplanentryval['smownerid']]['rolename'];
			if($assignedtouser_role == 'SMR')
				$allowed_status = array('Approved by Regional or Area Manager');
			else if(in_array($assignedtouser_role,array('DIY Supervisor','PCO Supervisor')))
				$allowed_status = array('Pending For Approval');
		}
		if(in_array($workplanentryval['z_wpe_status'], $allowed_status)){
			$currentModule = 'XWorkplanEntry';
			$record = $workplanentryval['xworkplanentryid'];
			
			$focus = CRMEntity::getInstance($currentModule);
			$focus->retrieve_entity_info($record, $currentModule);
			$focus->id  = "x".$record;

			approveToNSMWorkplanEntry($focus);
		}
	}
	
	header("Location: index.php?action=DetailView&module=XWorkplan&record=$workplanid");
}

?>