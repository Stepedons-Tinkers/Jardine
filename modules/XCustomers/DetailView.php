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
require_once("include/nextixlib/BlockRestriction.php");

global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

$focus = CRMEntity::getInstance($currentModule);

$tool_buttons = Button_Check($currentModule);
$smarty = new vtigerCRM_Smarty();
$blockRestriction = new BlockRestriction();

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

//hide fields
$hideFieldsTPL = array();
if($focus->column_fields['z_cu_customertype'] != 'Modern Trade')
	array_push($hideFieldsTPL,'z_cu_chainname');
//hide fields end

//hide blocks
	if(!empty($focus->column_fields['z_cu_customertype'])){
		$blockRestriction->getBlocksShown_customer($focus->column_fields['z_cu_customertype']);
	}
//hide blocks end	

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
	
	//hide related blocks
	$relatedblocksShown = $blockRestriction->getRelatedblocksShown();
	foreach($related_array as $relatedname => $value){
		if(!in_array($relatedname,$relatedblocksShown)){
			unset($related_array[$relatedname]);
		}
	}
	//hide related blocks end	
	
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

$modules_actions = array();
if($current_user->isSupreme || in_array($current_user->rolename, array('Marketing Manager','Brand Assistant / Marketing Service Assistant'))){
	//isactive
	if($focus->column_fields['z_cu_isactive'] != 1)
		$modules_actions[0]['link'] = "<a class='webMnu' href='index.php?module=NextIXfunctions&action={$currentModule}&functionNextIX=activate&entityid={$focus->id}' onclick='return jQuery.fn.confirmationPrompt();'>Activate</a>";
	else
		$modules_actions[1]['link'] = "<a class='webMnu' href='index.php?module=NextIXfunctions&action={$currentModule}&functionNextIX=deactivate&entityid={$focus->id}' onclick='return jQuery.fn.confirmationPrompt();'>Deactivate</a>";
	//status
	if($focus->column_fields['z_cu_customerrecstat'] == "Pending For Approval")
		$modules_actions[2]['link'] = "<a class='webMnu' href='index.php?module=NextIXfunctions&action={$currentModule}&functionNextIX=approve&entityid={$focus->id}' onclick='return jQuery.fn.confirmationPrompt();'>Approve</a>";
}
$smarty->assign("MODULES_ACTIONS", $modules_actions);

$smarty->assign('hideFieldsTPL', $hideFieldsTPL);

$smarty->assign('DETAILVIEW_AJAX_EDIT', PerformancePrefs::getBoolean('DETAILVIEW_AJAX_EDIT', true));

$smarty->display('DetailView.tpl');

?>