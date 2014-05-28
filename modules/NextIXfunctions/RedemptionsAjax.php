<?php
$function = $_REQUEST['functionNextIX'];
$function();	

function check_count(){
	global $adb,$current_user;
	$rdarea_id = $_REQUEST['rdarea_id'];
	$rd_type = $_REQUEST['rd_type'];
	$memcard_id = $_REQUEST['memcard_id'];
	$type_id = $_REQUEST['type_id'];

	$extra = ' ';
	$capCount = $rwpts_total = $rda_dailylimit = $rwpts_trans = 0;
	$curr_date = date('Y-m-d');
	$ary = array();
	if($rd_type == 'reward'){
		$pv_rw = 'rw';
		$cap_name = 'z_rw_rd_dailylimit';
		// $extra = " AND date(z_rd_timestamp_rw) = '2013-12-27'";
		$extra = " AND date(z_rd_timestamp_rw) = '".$curr_date."'";
		$cnt = " Daily Limit";
	}else{
		$pv_rw = 'pv';
		$cap_name = 'z_pv_rdcap_count';
		$cnt = " Cap Count";
	}
	
	$query = "SELECT * FROM vtiger_".$rd_type."s WHERE ".$rd_type."sid = ?";
	$rs = $adb->pquery($query,array($type_id));
	$rs_rows = $adb->num_rows($rs);
	if ($rs_rows > 0) $capCount = $adb->query_result($rs, 0, $cap_name);
		
	$query3 = "SELECT * FROM vtiger_redemptionareaspp WHERE redemptionareasppid = ?";
	$rs3 = $adb->pquery($query3,array($rdarea_id));
	$rs_rows3 = $adb->num_rows($rs3);
	if ($rs_rows3 > 0) $rda_dailylimit = $adb->query_result($rs3, 0, 'z_rda_rddaily_limit');
	
	// $query2 = "SELECT * FROM vtiger_redemptions WHERE z_rd_".$rd_type."_id = ?".$extra;
	$query2 = "SELECT * FROM vtiger_redemptions WHERE z_rd_rdarea_id = ?".$extra;
	// $rs2 = $adb->pquery($query2,array($type_id));
	$rs2 = $adb->pquery($query2,array($rdarea_id));
	$record_cntr = ($adb->num_rows($rs2)) + 1;
	
	$query4 = "SELECT * FROM vtiger_redemptions WHERE z_rd_".$rd_type."_id = ?".$extra;
	$rs4 = $adb->pquery($query4,array($type_id));
	$record_cntr2 = ($adb->num_rows($rs4)) + 1;
	// if ($rs_rows > 0) $record_cntr2 = $adb->query_result($rs4, 0, $cap_name);
	
	if($rd_type == 'reward'){
		$rwpts_trans =  $adb->query_result($rs, 0, 'z_rw_rwpts_trans');
		$query3 = "SELECT * FROM vtiger_membershipcards WHERE membershipcardsid = ?";
		$rs = $adb->pquery($query3,array($memcard_id));
		$rs_rows = $adb->num_rows($rs);
		$date_valid = $adb->query_result($rs, 0, 'z_mc_validuntil');
		if ($rs_rows > 0) $rwpts_total = $adb->query_result($rs, 0, 'z_mc_totalrewardpoints');

		if(!(intval($rwpts_trans) < intval($rwpts_total)))
			$ary[] = "The Reward points from this transaction has exceeded the Membership Card's 'Total Reward Points'.";
	} 
	
	if(intval($record_cntr) > intval($rda_dailylimit)) $ary[] = "You have reached the related Redemption Area's daily limit.";

	if(intval($record_cntr2) > intval($capCount)) $ary[] = "This redemption count has reached the Redemption".$cnt;
			
	if (!empty($ary)) echo json_encode(array('error'=>$ary, 'bool'=>false));
	else echo json_encode(array('error'=>'', 'bool'=>true));		
}
?>