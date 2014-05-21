<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule;

checkFileAccessForInclusion("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

//if image added then we have to set that $_FILES['name'] in imagename field then only the image will be displayed
if($_FILES['#_$IMAGEHERE_#']['name'] != '')
{
	if(isset($_REQUEST['#_$IMAGEHERE_#_hidden'])) {
		$focus->column_fields['#_$IMAGEHERE_#'] = vtlib_purify($_REQUEST['product_image_hidden']);
	} else {
		$focus->column_fields['#_$IMAGEHERE_#'] = $_FILES['#_$IMAGEHERE_#']['name'];
	}
}
elseif($focus->id != '')
{
	$result = $adb->pquery("select #_$IMAGEHERE_# from vtiger_#_MODULENAME_# where #_MODULEID_# = ?", array($focus->id));
	$focus->column_fields['#_$IMAGEHERE_#'] = $adb->query_result($result,0,'#_$IMAGEHERE_#');
}


$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

$focus->save($currentModule);
$return_id = $focus->id;

$search = vtlib_purify($_REQUEST['search_url']);

$parenttab = getParentTab();
if($_REQUEST['return_module'] != '') {
	$return_module = vtlib_purify($_REQUEST['return_module']);
} else {
	$return_module = $currentModule;
}

if($_REQUEST['return_action'] != '') {
	$return_action = vtlib_purify($_REQUEST['return_action']);
} else {
	$return_action = "DetailView";
}

if($_REQUEST['return_id'] != '') {
	$return_id = vtlib_purify($_REQUEST['return_id']);
}

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".vtlib_purify($_REQUEST['pagenumber']).$search);

?>