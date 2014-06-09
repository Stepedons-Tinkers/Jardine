<?php
// error_reporting(E_ALL);
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/index.php,v 1.93 2005/04/21 16:17:25 ray Exp $
 * Description: Main file and starting point for the application.  Calls the 
 * theme header and footer files defined for the user as well as the module as 
 * defined by the input parameters.
 ********************************************************************************/

global $entityDel;
global $display;
global $category;
global $audit_trail;


$current_user = new Users();


	//$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
	//getting the current user info from flat file
	$result = $current_user->retrieveCurrentUserInfoFromFile($_SESSION['authenticated_user_id']);

	if($result == null)
	{
		session_destroy();
	    header("Location: index.php?action=Login&module=Users");
	}

	$moduleList = getPermittedModuleNames();

        foreach ($moduleList as $mod) {
                $moduleDefaultFile[$mod] = "modules/".$currentModule."/index.php";
        }

	//auditing

	require_once('user_privileges/audit_trail.php');
	
	if($audit_trail == 'true')
	{
		if($record == '')
			$auditrecord = '';						
		else
			$auditrecord = $record;	

		/* Skip audit trial log for special request types */
		$skip_auditing = false;
		if($action == 'chat') { 
			$skip_auditing = true;		
		} else if(($action == 'ActivityReminderCallbackAjax' || $_REQUEST['file'] == 'ActivityReminderCallbackAjax') && $module == 'Calendar') {
			$skip_auditing = true;
		} else if(($action == 'TraceIncomingCall' || $_REQUEST['file'] == 'TraceIncomingCall') && $module == 'PBXManager') {
			$skip_auditing = true;
		}
		/* END */
		if (!$skip_auditing) {
			$date_var = $adb->formatDate(date('Y-m-d H:i:s'), true);
			$query = "insert into vtiger_audit_trial values(?,?,?,?,?,?)";
			$qparams = array($adb->getUniqueID('vtiger_audit_trial'), $current_user->id, $module, $action, $auditrecord, $date_var);
			$adb->pquery($query, $qparams);
		}	
	}	


// //ed edited 
// //add user_role
// $current_user->rolename = getRoleName($current_user->roleid);	//include/utils/UserInfoUtil.php
// //Supreme Admin
// $current_user->isSupreme = 0;
// $supremeAdmins = getSupremeAdmins(); 	//include/utils/CommonUtils.php
// if(in_array($current_user->user_name,$supremeAdmins)){
	// $current_user->isSupreme = 1;
// }
// $supremeAdmins = array();
// //ed edited end


?>