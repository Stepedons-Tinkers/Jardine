<?php
$function = $_REQUEST['functionNextIX'];
$function();	

function getCGUdetails($cgu_id){
	global $adb,$current_user;
	$query = "SELECT *
				FROM vtiger_casinogamingunits
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_casinogamingunits.casinogamingunitsid
				LEFT JOIN vtiger_games ON vtiger_games.gamesid = vtiger_casinogamingunits.z_cgu_game
				WHERE vtiger_crmentity.deleted = 0 
				AND casinogamingunitsid = ?";
	$rs = $adb->pquery($query,array($cgu_id));
	$noofrows = $adb->num_rows($rs);
	if($noofrows) {
		while($row = $adb->fetchByAssoc($rs)) {
			$data = $row;
		}
    }
	return $data;
}

function check_eligibility($cgu_data, $pnt_type){
	$isEligible = '2';

	if($pnt_type=='Tier') $isEligible = $cgu_data['z_cgu_eligibletierpnts'];
	else $isEligible = $cgu_data['z_cgu_eligiblerewardpnts'];
	
	return $isEligible;
}

function check_discrepancy($bet_amt,$cgu_data){
	global $adb,$current_user;
	$return = false;
	$min = $max = 0;
		
	$rs_rows = $adb->num_rows($cgu_data);
	if ($rs_rows > 0){
		$cgu_class = $cgu_data['z_cgu_classification'];
		
		if($cgu_class == 'Grind'){ 
			$min = $cgu_data['z_g_g_tableminimum'];
			$max =  $cgu_data['z_g_tablemaximum'];
			$return = ($bet_amt >= $min && $bet_amt <= $max);			
		}elseif($cgu_class == 'Premium'){
			$min =  $cgu_data['z_g_p_monitoredavebet'];
			$return = ($bet_amt >= $min);
		}
	}
	return $return;
}

function check_limits($pnt_type,$programid,$userid,$membershipcardsid,$bet_amt,$record, $createdtime=''){
	$empty_arr = $err = array();
	
	$ary = array(
		'Tier'=>array('ANY'=>'z_pnt_tierpoints_no'),
		'Bonus Rewards'=>array('ANY'=>'z_pnt_point_no'),
		'Base Rewards'=>array(
			'Table'=>'z_pnt_bet_amt_tab',
			'Machine'=>'z_pnt_bet_amt_mac',
			'Random Numbers'=>'z_pnt_bet_amt_num'
		)
	);
	
	
	//Module data
	// programs
	$ands = " AND programsid = ?";
	$flds = "programsid, z_p_rwpnt_issue,z_p_tierpnt_issue ";
	$program_data = getData_forPoints('programs', $programid, $flds, $ands);
	$programdailylimitlogs_data = queryprogramdailylimitlogs($programid, $createdtime);
	$program_data = getPointsBasedOnCreatedTime($program_data, $programdailylimitlogs_data, 'programs');
	
	// personnelassignements
	$ands = " AND z_pa_user = ?";
	$flds = "personnelassignmentsid, z_pa_tierpnts,z_pa_baserewardpnts,z_pa_bonusrewardpnts ";
	$personnelassign_data = getData_forPoints('personnelassignments', $userid, $flds, $ands);
	
	// membershipcard
	$ptiers_data = getDataMemCardsProgTiers_forPoints($membershipcardsid);
	// echo "<pre>";
	// print_r($ptiers_data);
	// echo "</pre>";
	$programtierlogs_data = queryprogramtierlogs($membershipcardsid, $createdtime);
	$ptiers_data = getPointsBasedOnCreatedTime($ptiers_data, $programtierlogs_data, 'programtiers');
	// echo "<pre>";
	// print_r($programtierlogs_data);
	// print_r($ptiers_data);
	// echo "</pre>";
	
	$ands = '';
	if(empty($program_data)) $empty_arr['Program'] = 'Record does not exist.';
	else {
		$joins = " LEFT JOIN vtiger_programs ON vtiger_programs.programsid = vtiger_points.z_pnt_program_id";
		$ands = " AND vtiger_points.z_pnt_program_id = ?";
		if($record!=0) $ands .= " AND vtiger_points.pointsid != {$record}";
		$prgData = getPointsData_checking($programid,$joins,$ands);
		
		$err['Program'] = checkDailyTransaction_prg($pnt_type, $program_data, $prgData, $ary, $bet_amt);
	}
	
	$ands = '';
	if(empty($personnelassign_data)) $empty_arr['Personnel Assignments'] = 'Record does not exist.';
	else {
		$joins = " LEFT JOIN vtiger_personnelassignments ON vtiger_personnelassignments.z_pa_user = vtiger_crmentity.smownerid";
		$ands = " AND vtiger_personnelassignments.z_pa_user = ?";
		if($record!=0) $ands .= " AND vtiger_points.pointsid != {$record}";
		$paData = getPointsData_checking($userid,$joins,$ands);
	
		$err['Personnel Assignments'] = checkDailyTransaction_pa($pnt_type, $personnelassign_data, $paData, $ary,$bet_amt);
	}
	
	$ands = '';
	if(empty($ptiers_data)) $empty_arr['Program Tier'] = 'Record does not exist.';
	else {
		$joins = " LEFT JOIN vtiger_membershipcards ON vtiger_membershipcards.membershipcardsid = vtiger_points.z_pnt_memcard_no
				   LEFT JOIN vtiger_programtiers ON vtiger_programtiers.programtiersid = vtiger_membershipcards.z_mc_programtier";
		$ands = " AND vtiger_points.z_pnt_memcard_no = ?";
		if($record!=0) $ands .= " AND vtiger_points.pointsid != {$record}";
		$ptData = getPointsData_checking($membershipcardsid,$joins,$ands);
		$err['Program Tier'] = checkDailyTransaction_pt($pnt_type, $ptiers_data, $ptData, $ary, $bet_amt);
	}
	
	return $err;
	
}

function getPointsData_checking($id,$joins='',$ands=''){
	global $adb;
	$curr_date = date('Y-m-d');

	$query = "SELECT pointsid, z_g_gametype, z_pnt_point_type, z_pnt_tierpoints_no, z_pnt_point_no,z_pnt_bet_amt_tab,z_pnt_bet_amt_mac,z_pnt_bet_amt_num
				FROM vtiger_points
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_points.pointsid
				LEFT JOIN vtiger_casinogamingunits ON vtiger_casinogamingunits.casinogamingunitsid = vtiger_points.z_pnt_cgu_id
				LEFT JOIN vtiger_games ON vtiger_games.gamesid = vtiger_casinogamingunits.z_cgu_game"
				.$joins.
				" WHERE vtiger_crmentity.deleted = 0
				AND date(vtiger_crmentity.createdtime) = ?"
				.$ands;
			
	$result = $adb->pquery($query,array($curr_date,$id));
	$noofrows = $adb->num_rows($result);
	$data = array();
	if($noofrows) {
		while($row = $adb->fetchByAssoc($result)) {
			$data[] = $row;
		}
    }
	return $data;
}

function checkDailyTransaction_prg($pnt_type, $maindata, $pData, $ary, $bet_amt){
	$pt_issue = $total_pt = 0;
	if($pnt_type == 'Tier') $pt_field = 'z_p_tierpnt_issue';
	else $pt_field = 'z_p_rwpnt_issue';

	foreach($pData as $data){
		if($pnt_type == $data['z_pnt_point_type']){
			if($data['z_pnt_point_type'] == 'Tier') $keyF = 'ANY';
			else if($data['z_pnt_point_type'] == 'Bonus Rewards') $keyF = 'ANY';
			else $keyF = $data['z_g_gametype'];

			$field_ = $ary[$data['z_pnt_point_type']][$keyF];
			$total_pt += (float)$data[$field_];
		}
	}
	$pt_issue =  (float)$maindata[$pt_field];
	
	// echo $pt_issue;
	// echo 'sad';
	// echo $total_pt+$bet_amt;
	
	return ($pt_issue>=($total_pt+$bet_amt));
}

function checkDailyTransaction_pa($pnt_type, $maindata, $pData, $ary,$bet_amt){
	$pt_issue = $total_pt = 0;
	if($pnt_type == 'Tier') $pt_field = 'z_pa_tierpnts';
	else if($pnt_type == 'Bonus Rewards') $pt_field = 'z_pa_bonusrewardpnts';
	else $pt_field = 'z_pa_baserewardpnts';
	
	if($pnt_type == $data['z_pnt_point_type']){
		foreach($pData as $data){
			if($data['z_pnt_point_type'] != 'Base Rewards') $keyF = 'ANY';
			else $keyF = $data['z_g_gametype'];

			$field_ = $ary[$data['z_pnt_point_type']][$keyF];
			$total_pt += (float)$data[$field_];
		}
	}
	$pt_issue =  (float)$maindata[$pt_field];
	
	// var_dump($maindata);
		// echo $pt_issue;
	// echo 'sad';
	// echo $total_pt+$bet_amt;
	return ($pt_issue>=($total_pt+$bet_amt));
}

function checkDailyTransaction_pt($pnt_type, $maindata, $pData, $ary, $bet_amt){
	$pt_issue = $total_pt = 0;
	if($pnt_type == 'Tier') $pt_field = 'z_pt_earnlimit_daytier';
	else $pt_field = 'z_pt_earnlimit_dayreward';
	
	foreach($pData as $data){
		if($pnt_type == $data['z_pnt_point_type']){
			if($data['z_pnt_point_type'] == 'Tier') $keyF = 'ANY';
			else if($data['z_pnt_point_type'] == 'Bonus Rewards') $keyF = 'ANY';
			else $keyF = $data['z_g_gametype'];
			
			$field_ = $ary[$data['z_pnt_point_type']][$keyF];
			$total_pt += (float)$data[$field_];
		}
	}
	$pt_issue =  (float)$maindata[$pt_field];
			// echo $pt_issue;
	// echo 'sad';
	// echo $total_pt+$bet_amt;
	return ($pt_issue>=($total_pt+$bet_amt));
}

function mainChecker(){
	global $adb;
	$key_arr = $err = array();
	$key_str = $cgu_class = '';
	
	$bet_amt = $_REQUEST['bet_amt'];
	$cgu_id = $_REQUEST['cgu_id'];
	$baserwdpts = $_REQUEST['baserwdpts'];
	$pnt_type = $_REQUEST['pnt_type'];
	$programid = $_REQUEST['programid'];
	$userid = $_REQUEST['userid'];
	$record = ($_REQUEST['record'] != '' ? $_REQUEST['record'] : 0);
	$membershipcardsid = $_REQUEST['membershipcardsid'];
	$createdtime = $_REQUEST['createdtime'];
	
	$cgu_data = getCGUdetails($cgu_id);
	$eligible = check_eligibility($cgu_data, $pnt_type);
	if($eligible == '2') $err[] = 'Casino Gaming Unit record cannot be found.';
	elseif($eligible == '0') $err[] = 'Selected Casino Gaming Unit is ineligible to issue ('.$pnt_type.') points';
	
	if($pnt_type == 'Base Rewards') {

		$cgu_class = $cgu_data['z_cgu_classification'];
		$game_id = $cgu_data['z_cgu_game'];
		$rewardfactor_logs = queryrewardfactorslogs($cgu_class, $game_id, $createdtime);
		// print_r($cgu_data);
		$cgu_data = getPointsBasedOnCreatedTime($cgu_data, $rewardfactor_logs, $cgu_class);
		// print_r($cgu_data);
		// print_r($rewardfactor_logs);
		$disc = check_discrepancy($bet_amt,$cgu_data);
		if(empty($disc))  $err[] = "Mismatched Casino Gaming Unit classification. Bet Amount may be less than or greater than the specified values of the Game played.";
		
		$baserwd_checking = check_limits($pnt_type,$programid,$userid,$membershipcardsid,$baserwdpts,$record,$createdtime);
		if(in_array(false,$baserwd_checking)){
			foreach($baserwd_checking as $ctgry=>$value){
				if(!$value) array_push($key_arr,$ctgry);
			}
			$key_str = implode(',',$key_arr);
			$err[] = "Can't proceed. Transaction is already beyond the set Daily Limit (Number of Base Reward Points): ".$key_str;
		}
	}
	
	$lmt = check_limits($pnt_type,$programid,$userid,$membershipcardsid,$bet_amt,$record,$createdtime);
	if(in_array(false,$lmt)){
		foreach($lmt as $ctgry=>$value){
			if(!$value) array_push($key_arr,$ctgry);
		}
		$key_str = implode(',',$key_arr);
		$err[] = "Can't proceed. Transaction is already beyond the set Daily Limit : ".$key_str;
	}
	
	if (!empty($err)) echo json_encode(array('error'=>$err, 'bool'=>false));
	else echo json_encode(array('error'=>'', 'bool'=>true));	
}

function queryprogramdailylimitlogs($programid, $createdtime=''){
	global $adb;
	$created_condition = '';
	if(!empty($createdtime)){
		$created_condition = " AND vtiger_crmentity.createdtime >= '{$createdtime}' ";
	}
	
	$query = "SELECT * FROM vtiger_programdailylimitlogs
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_programdailylimitlogs.programdailylimitlogsid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_programdailylimitlogs.z_pdll_program_id = ?
			{$created_condition} 
			ORDER BY vtiger_crmentity.createdtime ASC ";
	$result = $adb->pquery($query,array($programid));
	$noofrows = $adb->num_rows($result);
	$data = array();
	if($noofrows) {
		while($row = $adb->fetchByAssoc($result)) {
			$data[] = $row;
		}
    }
	return $data;			
}

function queryprogramtierlogs($membershipcardsid, $createdtime=''){
	global $adb;
	$created_condition = '';
	if(!empty($createdtime)){
		$created_condition = " AND vtiger_crmentity.createdtime >= '{$createdtime}' ";
	}
	
	$query = "SELECT * FROM vtiger_programtierlogs
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_programtierlogs.programtierlogsid
			LEFT JOIN vtiger_membershipcards ON vtiger_membershipcards.z_mc_programtier = vtiger_programtierlogs.z_ptl_programtier_id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_membershipcards.membershipcardsid = ?
			{$created_condition} 
			ORDER BY vtiger_crmentity.createdtime ASC ";
	$result = $adb->pquery($query,array($membershipcardsid));
	$noofrows = $adb->num_rows($result);
	$data = array();
	if($noofrows) {
		while($row = $adb->fetchByAssoc($result)) {
			$data[] = $row;
		}
    }
	return $data;			
}

function getPointsBasedOnCreatedTime($module_data, $logs_data, $module){
	if($module == 'programs'){
		$moduleField = array('Reward Points Issue'=>'z_p_rwpnt_issue', 'Tier Points Issue'=>'z_p_tierpnt_issue');
		$moduleField_logs = array('FieldName'=>'z_pdll_field_name','FieldValue'=>'z_pdll_from_value');
	}
	// else if($module == 'personnelassignments'){
		// $moduleField = array('Bonus Reward Points'=>'z_pa_bonusrewardpnts', 'Base Reward Points '=>'z_pa_baserewardpnts');
		// $moduleField_logs = array('FieldName'=>'z_pdll_field_name','FieldValue'=>'z_pdll_to_value');
	// }
	else if($module == 'programtiers'){
		$moduleField = array('Earning Limit in a Day (Tier)'=>'z_pt_earnlimit_daytier', 'Earning Limit in a Day (Reward)'=>'z_pt_earnlimit_dayreward');
		$moduleField_logs = array('FieldName'=>'z_ptl_field_name','FieldValue'=>'z_ptl_from_value');
	}
	else if($module == 'Grind'){
		$moduleField = array('Table Minimum'=>'z_g_g_tableminimum', 'Table Maximum'=>'z_g_tablemaximum');
		$moduleField_logs = array('FieldName'=>'z_grfl_fieldname','FieldValue'=>'z_grfl_fromvalue');
	}
	else if($module == 'Premium'){
		$moduleField = array('Monitored Average Bet'=>'z_g_p_monitoredavebet');
		$moduleField_logs = array('FieldName'=>'z_prfl_fieldname','FieldValue'=>'z_prfl_fromvalue');
	}
	
	$finishedFields = array();
	foreach($logs_data as $logsValue){
		if(!in_array($logsValue[$moduleField_logs['FieldName']], $finishedFields) && isset($moduleField[$logsValue[$moduleField_logs['FieldName']]])){
			$module_data[$moduleField[$logsValue[$moduleField_logs['FieldName']]]] = $logsValue[$moduleField_logs['FieldValue']];
			$finishedFields[] = $logsValue[$moduleField_logs['FieldName']];
		}
	}
	return $module_data;
	//replace only what is in the Log
}

function queryrewardfactorslogs($cgu_class, $game_id, $createdtime=''){
	global $adb;
	$data = array();
	$created_condition = '';
	if(!empty($createdtime)){
		$created_condition = " AND vtiger_crmentity.createdtime >= '{$createdtime}' ";
	}
	
	$query = "SELECT * FROM vtiger_".strtolower($cgu_class)."rewardfactorlogs
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_".strtolower($cgu_class)."rewardfactorlogs.".strtolower($cgu_class)."rewardfactorlogsid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_".strtolower($cgu_class)."rewardfactorlogs.z_".substr(strtolower($cgu_class), 0,1)."rfl_games = ?
			{$created_condition} 
			ORDER BY vtiger_crmentity.createdtime ASC ";
	$result = $adb->pquery($query,array($game_id));
	// echo $query;
	// echo $game_id;
	$noofrows = $adb->num_rows($result);
	if($noofrows) {
		while($row = $adb->fetchByAssoc($result)) {
			$data[] = $row;
		}
    }
	return $data;			
}

?>