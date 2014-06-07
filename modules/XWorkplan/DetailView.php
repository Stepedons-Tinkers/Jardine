<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('Smarty_setup.php');
require_once('user_privileges/default_module_view.php');

global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

$focus = CRMEntity::getInstance($currentModule);

$tool_buttons = Button_Check($currentModule);
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = vtlib_purify($_REQUEST['isDuplicate']);
$tabid = getTabid($currentModule);
$category = getParentTab($currentModule);

if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
if($isduplicate == 'true') $focus->id = '';

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', 'SINGLE_'.$currentModule); 
$smarty->assign('CATEGORY', $category);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);

$recordName = array_values(getEntityName($currentModule, $focus->id));
$recordName = $recordName[0];
$smarty->assign('NAME', $recordName);
$smarty->assign('UPDATEINFO',updateInfo($focus->id));

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$validationArray = split_validationdataArray(getDBValidationData($focus->tab_name, $tabid));
$smarty->assign('VALIDATION_DATA_FIELDNAME',$validationArray['fieldname']);
$smarty->assign('VALIDATION_DATA_FIELDDATATYPE',$validationArray['datatype']);
$smarty->assign('VALIDATION_DATA_FIELDLABEL',$validationArray['fieldlabel']);

$smarty->assign('EDIT_PERMISSION', isPermitted($currentModule, 'EditView', $record));
$smarty->assign('CHECK', $tool_buttons);

if(PerformancePrefs::getBoolean('DETAILVIEW_RECORD_NAVIGATION', true) && isset($_SESSION[$currentModule.'_listquery'])){
	$recordNavigationInfo = ListViewSession::getListViewNavigation($focus->id);
	VT_detailViewNavigation($smarty,$recordNavigationInfo,$focus->id);
}

$smarty->assign('IS_REL_LIST', isPresentRelatedLists($currentModule));
$smarty->assign('SinglePane_View', $singlepane_view);

if($singlepane_view == 'true') {
	$related_array = getRelatedLists($currentModule,$focus);
	$smarty->assign("RELATEDLISTS", $related_array);
		
	require_once('include/ListView/RelatedListViewSession.php');
	if(!empty($_REQUEST['selected_header']) && !empty($_REQUEST['relation_id'])) {
		RelatedListViewSession::addRelatedModuleToSession(vtlib_purify($_REQUEST['relation_id']),
				vtlib_purify($_REQUEST['selected_header']));
	}
	$open_related_modules = RelatedListViewSession::getRelatedModulesFromSession();
	$smarty->assign("SELECTEDHEADERS", $open_related_modules);
}

if(isPermitted($currentModule, 'EditView', $record) == 'yes')
	$smarty->assign('EDIT_DUPLICATE', 'permitted');
if(isPermitted($currentModule, 'Delete', $record) == 'yes' && $focus->checkForDependencies($module, $record))
	$smarty->assign('DELETE', 'permitted');

$smarty->assign('BLOCKS', getBlocks($currentModule,'detail_view','',$focus->column_fields));

// Gather the custom link information to display
include_once('vtlib/Vtiger/Link.php');
$customlink_params = Array('MODULE'=>$currentModule, 'RECORD'=>$focus->id, 'ACTION'=>vtlib_purify($_REQUEST['action']));
$smarty->assign('CUSTOM_LINKS', Vtiger_Link::getAllByType(getTabid($currentModule), Array('DETAILVIEWBASIC','DETAILVIEW','DETAILVIEWWIDGET'), $customlink_params));
// END

// Record Change Notification
$focus->markAsViewed($current_user->id);
// END

$workplanentries_detail = getWorkplanEntriesDetail(array($focus->id));
$workplanentries_total = count($workplanentries_detail[$focus->id]);
foreach($workplanentries_detail[$focus->id] as $workplanentryid => $workplanentryval){
	//use assigned to of workplan since same assigned to rana cya sa tanan workplan entries
	if(in_array($workplanentryval['z_wpe_status'], array('Pending For Approval','Approved by Regional or Area Manager'))){
		if($workplanentryval['z_wpe_status'] == 'Pending For Approval'){
		
		}
		else if($workplanentryval['z_wpe_status'] == 'Approved by Regional or Area Manager'){
		
		}
	}
}

$modules_actions = array();
$assignedtouser_detail = getUserDetails_id(array($focus->column_fields['assigned_user_id']));
$assignedtouser_role = $assignedtouser_detail[$focus->column_fields['assigned_user_id']]['rolename'];
$workplanentries_detail = getWorkplanEntriesDetail(array($focus->id));
$workplanentries_total = count($workplanentries_detail[$focus->id]);
$workplanentries_lack = 0;
$approveAction = '';
foreach($workplanentries_detail[$focus->id] as $workplanentryid => $workplanentryval){
	if($assignedtouser_role == 'SMR'){
		if(($current_user->isSupreme || $current_user->rolename == 'Regional / Area Sales Manager') && $workplanentryval['z_wpe_status'] == 'Pending For Approval'){
			$workplanentries_lack++;
			$approveAction = 'approveToRegional';
		}
		else if(($current_user->isSupreme || $current_user->rolename == 'National Sales Manager') && in_array($workplanentryval['z_wpe_status'], array('Pending For Approval','Approved by Regional or Area Manager'))){
			$workplanentries_lack++;
			$approveAction = 'approveToNSM';
		}
	}
	else if(in_array($assignedtouser_role,array('DIY Supervisor','PCO Supervisor'))){
		if($workplanentryval['z_wpe_status'] == 'Pending For Approval' && ($current_user->isSupreme || $current_user->rolename == 'National Sales Manager')){
			$workplanentries_lack++;
			$approveAction = 'approveToNSM';
		}	
	}
}
$workplanentries_approved = $workplanentries_total - $workplanentries_lack;
$left_str = $workplanentries_approved."/".$workplanentries_total;
if(!empty($workplanentries_lack))
	$modules_actions[0]['link'] = "<a class='webMnu' href='index.php?module=NextIXfunctions&action={$currentModule}&functionNextIX={$approveAction}&entityid={$focus->id}' onclick='return jQuery.fn.confirmationPrompt();'>Approve ({$left_str})</a>";

$smarty->assign("MODULES_ACTIONS", $modules_actions);

$smarty->assign('DETAILVIEW_AJAX_EDIT', PerformancePrefs::getBoolean('DETAILVIEW_AJAX_EDIT', true));

$smarty->display('DetailView.tpl');

?>