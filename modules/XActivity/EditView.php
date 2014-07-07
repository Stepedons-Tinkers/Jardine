<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $app_strings, $mod_strings, $current_language, $currentModule, $theme, $current_user;
require_once('Smarty_setup.php');
require_once('include/nextixlib/EditViewClasses.php');
require_once 'include/nextixlib/ModuleDependency.php';
require_once("include/nextixlib/BlockRestriction.php");

$focus = CRMEntity::getInstance($currentModule);
$smarty = new vtigerCRM_Smarty();
$editViewClasses = new EditViewClasses();
$moduleDependency = new ModuleDependency();
$blockRestriction = new BlockRestriction();

//From Related List
if(isset($_REQUEST['z_ac_workplanentry']) && $_REQUEST['z_ac_workplanentry'] != ''){
	$focus_wpe = CRMEntity::getInstance("XWorkplanEntry");
	$focus_wpe->id = $_REQUEST['z_ac_workplanentry'];
	$focus_wpe->retrieve_entity_info_nextix($_REQUEST['z_ac_workplanentry'], "XWorkplanEntry");
	// $_REQUEST['z_ac_customer'] = $focus_wpe->column_fields['z_wpe_customer'];
	// $_REQUEST['z_ac_customer_type'] = 'XCustomers';
	$_REQUEST['z_ac_activitytype'] = $focus_wpe->column_fields['z_wpe_activitytype'];
	$_REQUEST['z_ac_activitytype_type'] = 'XActivityType';
	$_REQUEST['z_ac_workplan'] = $focus_wpe->column_fields['z_wpe_workplan'];
	$_REQUEST['z_ac_workplan_type'] = 'XWorkplan';
	$_REQUEST['assigned_user_id'] = $focus_wpe->column_fields['assigned_user_id'];
}
//For Related List End

$category = getParentTab($currentModule);
$record = $_REQUEST['record'];
$isduplicate = vtlib_purify($_REQUEST['isDuplicate']);

//added to fix the issue4600
$searchurl = getBasic_Advance_SearchURL();
$smarty->assign("SEARCH", $searchurl);
//4600 ends

if($record) {
	$focus->id = $record;
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($record, $currentModule);
}
else{
	$focus->column_fields['z_ac_source'] = 'Web';
	if(!empty($current_user->businessunit['id'])){
		$_REQUEST['z_ac_businessunit'] = $current_user->businessunit['id'];
		$_REQUEST['z_ac_businessunit_type'] = 'XBusinessUnit';
	}
}

if($isduplicate == 'true') {
	$focus->id = '';
	$focus->mode = '';
}
if(empty($_REQUEST['record']) && $focus->mode != 'edit'){
	setObjectValuesFromRequest($focus);
}

if(in_array($current_user->rolename, array('SMR','DIY Supervisor','PCO Supervisor'))){
	$smrs_details = getUserDetails_id(array($current_user->id));
}
else if($current_user->rolename == 'Regional / Area Sales Manager'){
	$smrs_details = getSMRs_area($current_user->area);
}
else{
	$smrs_details = getUsers_roles(array('SMR','DIY Supervisor','PCO Supervisor'));
}

foreach($smrs_details as $key => $value){
	$picklist_array['assigned_user_id'][$key] = $value['first_name'].' '.$value['last_name'];
}

if($focus->mode != 'edit' && $focus->column_fields['assigned_user_id'] == '') {
	foreach($smrs_details as $id => $value){
		$focus->column_fields['assigned_user_id'] = $id;
		break;
	}
}

$custom_mandatory = array('z_ac_smr','z_ac_issuesidentified','z_ac_feedbackfromcu','z_ac_ongoingcampaigns',
		'z_ac_projectname','z_ac_projectstage','z_ac_projectcategory','z_ac_date',
		'z_ac_time','z_ac_venue','z_ac_noofattenees','z_ac_attendees','z_ac_attendancesheet');

$disp_view = getView($focus->mode);
	$blocks = getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields);
	// $basblocks = getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields, 'BAS');
	// $advblocks = getBlocks($currentModule,$disp_view,$mode,$focus->column_fields,'ADV');

	$keyArray = $editViewClasses->findKeyInBlocks($blocks);
	$blocks = $editViewClasses->leavingSetOfPicklistValue_assignedto($blocks,$keyArray,array('assigned_user_id'),$picklist_array);
	
	//fake mandatory 
	foreach($custom_mandatory as $fields){
		$key1 = $keyArray[$fields][0];
		$key2 = $keyArray[$fields][1];
		$key3 = $keyArray[$fields][2];	

		$blocks[$key1][$key2][$key3][4] = "M";
	}
	
	$smarty->assign('BLOCKS', $blocks);
	$smarty->assign('BASBLOCKS', $blocks);
	// $smarty->assign('ADVBLOCKS', $advblocks);

//hide blocks
	$hideBlocksTPL = array();
	$forcedisable = array('z_ac_source','z_ac_othersacttypermrk','z_ac_reasonremarks','z_ac_details');
	if(!empty($focus->column_fields['z_ac_activitytype'])){
		$allBlocks = array("General Information", "With CoSMRs", "DIY or Supermarket", "Project Visit", "Trainings");
		$showBlocks = $blockRestriction->getBlocksShown_activity($focus->column_fields['z_ac_activitytype']);
		$forcedisable = $blockRestriction->getDisableField_activity($forcedisable);
		$hideBlocksTPL = array_diff($allBlocks, $showBlocks['value']);
	}
	else{
		$hideBlocksTPL = array("With CoSMRs", "DIY or Supermarket", "Project Visit", "Trainings");
	}
//hide blocks end	
	
// echo "<pre>";

// print_r($basblocks);
// print_r($blocks);
// echo "</pre>";
$smarty->assign("UPLOADSIZE", $upload_maxsize/1000000); //Convert to MB
$smarty->assign("UPLOAD_MAXSIZE",$upload_maxsize);
if($_REQUEST['upload_error'] == true)
{
	echo '<br><b><font color="red"> '.$mod_strings['FILE_HAS_NO_DATA'].'.</font></b><br>';
}

$smarty->assign('OP_MODE',$disp_view);
$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', 'SINGLE_'.$currentModule);
$smarty->assign('CATEGORY', $category);
$smarty->assign("THEME", $theme);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);
$smarty->assign('CREATEMODE', vtlib_purify($_REQUEST['createmode']));

$smarty->assign('CHECK', Button_Check($currentModule));
$smarty->assign('DUPLICATE', $isduplicate);

if($focus->mode == 'edit' || $isduplicate) {
	$recordName = array_values(getEntityName($currentModule, $record));
	$recordName = $recordName[0];
	$smarty->assign('NAME', $recordName);
	$smarty->assign('UPDATEINFO',updateInfo($record));
}

if(isset($_REQUEST['return_module']))    $smarty->assign("RETURN_MODULE", vtlib_purify($_REQUEST['return_module']));
if(isset($_REQUEST['return_action']))    $smarty->assign("RETURN_ACTION", vtlib_purify($_REQUEST['return_action']));
if(isset($_REQUEST['return_id']))        $smarty->assign("RETURN_ID", vtlib_purify($_REQUEST['return_id']));
if (isset($_REQUEST['return_viewname'])) $smarty->assign("RETURN_VIEWNAME", vtlib_purify($_REQUEST['return_viewname']));

// Field Validation Information
$tabid = getTabid($currentModule);
$validationData = getDBValidationData($focus->tab_name,$tabid);

//ed edited
foreach($validationData as $key => $fieldvalue){
	if(in_array($key,$custom_mandatory))
		foreach($fieldvalue as $key2 => $datatype)
			$validationData[$key][$key2] = str_replace('~O','~M',$datatype);
}	
//ed edited end

$validationArray = split_validationdataArray($validationData);

	
$smarty->assign("VALIDATION_DATA_FIELDNAME",$validationArray['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$validationArray['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$validationArray['fieldlabel']);

// In case you have a date field
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("CALENDAR_DATEFORMAT", parse_calendardate($app_strings['NTC_DATE_FORMAT']));

global $adb;
// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if($focus->mode != 'edit' && $mod_seq_field != null) {
		$autostr = getTranslatedString('MSG_AUTO_GEN_ON_SAVE');
		$mod_seq_string = $adb->pquery("SELECT prefix, cur_id from vtiger_modentity_num where semodule = ? and active=1",array($currentModule));
        $mod_seq_prefix = $adb->query_result($mod_seq_string,0,'prefix');
        $mod_seq_no = $adb->query_result($mod_seq_string,0,'cur_id');
        if($adb->num_rows($mod_seq_string) == 0 || $focus->checkModuleSeqNumber($focus->table_name, $mod_seq_field['column'], $mod_seq_prefix.$mod_seq_no))
                echo '<br><font color="#FF0000"><b>'. getTranslatedString('LBL_DUPLICATE'). ' '. getTranslatedString($mod_seq_field['label'])
                	.' - '. getTranslatedString('LBL_CLICK') .' <a href="index.php?module=Settings&action=CustomModEntityNo&parenttab=Settings&selmodule='.$currentModule.'">'.getTranslatedString('LBL_HERE').'</a> '
                	. getTranslatedString('LBL_TO_CONFIGURE'). ' '. getTranslatedString($mod_seq_field['label']) .'</b></font>';
        else
                $smarty->assign("MOD_SEQ_ID",$autostr);
} else {
	$smarty->assign("MOD_SEQ_ID", $focus->column_fields[$mod_seq_field['name']]);
}
// END

// Gather the help information associated with fields
$smarty->assign('FIELDHELPINFO', vtlib_getFieldHelpInfo($currentModule));
// END

$picklistDependencyDatasource = Vtiger_DependencyPicklist::getPicklistDependencyDatasource($currentModule);
$smarty->assign("PICKIST_DEPENDENCY_DATASOURCE", Zend_Json::encode($picklistDependencyDatasource));

$uitype10_fields = $moduleDependency->getModuleDependency_module($currentModule);
if($uitype10_fields)
	$smarty->assign("uitype10_fields", json_encode($uitype10_fields));

$smarty->assign("hideBlocksTPL",$hideBlocksTPL);  
$smarty->assign('forcedisable', $forcedisable);
	
if($focus->mode == 'edit') {
	$smarty->display('salesEditView.tpl');
} else {
	$smarty->display('CreateView.tpl');
}

?>