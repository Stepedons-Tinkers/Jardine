<?php
// We are using manual adb query, so that if there is block of records, there wont be a problem;
global $adb;

$current_module = $_REQUEST['current_module'];
$recordid = $_REQUEST['recordid'];
$target_fieldname = $_REQUEST['target_fieldname'];

$ary = array();
if($current_module == 'PersonnelAssignments'){
	if($target_fieldname == 'z_pa_user'){
		$query = "SELECT * FROM vtiger_users WHERE id = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$last_name = $adb->query_result($rs, 0, 'last_name');
			$first_name = $adb->query_result($rs, 0, 'first_name');
			
			$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'last_name');
			$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'first_name');
		}
	}
}
else if($current_module == 'MembershipCards'){
	if($target_fieldname == 'z_mc_memberid'){
		$query = "SELECT * FROM vtiger_members WHERE membersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$last_name = $adb->query_result($rs, 0, 'z_m_lastname');
			$first_name = $adb->query_result($rs, 0, 'z_m_firstname');
			
			$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'z_m_lastname');
			$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'z_m_firstname');
		}
	}
}
else if($current_module == 'PaymentsPP'){
	if($target_fieldname == 'z_pay_members'){
		$query = "SELECT * FROM vtiger_members WHERE membersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$last_name = $adb->query_result($rs, 0, 'z_m_lastname');
			$first_name = $adb->query_result($rs, 0, 'z_m_firstname');
			
			$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'z_m_lastname');
			$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'z_m_firstname');
		}
	}
	else if($target_fieldname == 'z_pay_programmembershipfees'){
		$query = "SELECT * FROM vtiger_programmembershipfees WHERE ProgramMembershipFeesid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$z_pmf_price = $adb->query_result($rs, 0, 'z_pmf_price');
			$ary[] = array('recordid'=>'', 'value'=>$z_pmf_price, 'target_fieldname'=>'z_pay_amountpaid');
		}		
	}
} else if($current_module == 'Points'){
	if($target_fieldname == 'z_pnt_member_id'){
		$query = "SELECT * FROM vtiger_members WHERE membersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$last_name = $adb->query_result($rs, 0, 'z_m_lastname');
			$first_name = $adb->query_result($rs, 0, 'z_m_firstname');
			
			$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'z_m_lastname');
			$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'z_m_firstname');
		}
	}else if($target_fieldname == 'z_pnt_memcard_no'){
		$query = "SELECT * FROM vtiger_membershipcards WHERE membershipcardsid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$membersid = $adb->query_result($rs, 0, 'z_mc_memberid');
			$query1 = "SELECT * FROM vtiger_members WHERE membersid = ?";
			$rs1 = $adb->pquery($query1,array($membersid));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$memname = $adb->query_result($rs1, 0, 'z_m_memberid');
				$last_name = $adb->query_result($rs1, 0, 'z_m_lastname');
				$first_name = $adb->query_result($rs1, 0, 'z_m_firstname');
				
				$ary[] = array('recordid'=>$membersid, 'value'=>$memname, 'target_fieldname'=>'z_pnt_member_id');
				$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'z_m_lastname');
				$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'z_m_firstname');
			}
			
		}
	}else if($target_fieldname == 'z_pnt_cgu_id'){
		$query = "SELECT * FROM vtiger_casinogamingunits WHERE casinogamingunitsid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$table_type = $adb->query_result($rs, 0, 'z_cgu_classification');
			$ary[] = array('recordid'=>'', 'value'=>$table_type, 'target_fieldname'=>'z_cgu_classification');		
			
			$game_id = $adb->query_result($rs, 0, 'z_cgu_game');
			$query1 = "SELECT * FROM vtiger_games WHERE gamesid = ?";
			$rs1 = $adb->pquery($query1,array($game_id));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$data_games = array();
				while($row = $adb->fetchByAssoc($rs1)) 
					$data_games = $row;
				// $game_type = $adb->query_result($rs1, 0, 'z_g_gametype');
				$game_type = $data_games['z_g_gametype'];
				
				$ary[] = array('recordid'=>'', 'value'=>$game_type, 'target_fieldname'=>'z_g_gametype');
		
				if($table_type == 'Grind'){
					$compute = $data_games['z_g_g_tableminimum'] * $data_games['z_g_g_betcount']* ($data_games['z_g_houseadvantage']/100) * ($data_games['z_g_g_comprate']/100) * $data_games['z_g_g_conversionfactor'];
					$ary[] = array('recordid'=>'', 'value'=>round($compute,2), 'target_fieldname'=>'z_pnt_baserwrdpts_no_tab');
				}
				else if($table_type == 'Premium'){
					$compute = $data_games['z_g_p_monitoredavebet'] * $data_games['z_g_p_betcount']* ($data_games['z_g_houseadvantage']/100) * ($data_games['z_g_p_comprate']/100) * $data_games['z_g_p_conversionfactor'];
					$ary[] = array('recordid'=>'', 'value'=>round($compute,2), 'target_fieldname'=>'z_pnt_baserwrdpts_no_tab');
				}
				
			}
		}	
	}
}else if($current_module == 'Redemptions'){
	if($target_fieldname == 'z_rd_membershipcardid'){
		$query = "SELECT * FROM vtiger_membershipcards WHERE membershipcardsid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$membersid = $adb->query_result($rs, 0, 'z_mc_memberid');
			$query1 = "SELECT * FROM vtiger_members WHERE membersid = ?";
			$rs1 = $adb->pquery($query1,array($membersid));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$memname = $adb->query_result($rs1, 0, 'z_m_memberid');
				$last_name = $adb->query_result($rs1, 0, 'z_m_lastname');
				$first_name = $adb->query_result($rs1, 0, 'z_m_firstname');
				
				$ary[] = array('recordid'=>$membersid, 'value'=>$memname, 'target_fieldname'=>'z_rd_member_id');
				$ary[] = array('recordid'=>'', 'value'=>$last_name, 'target_fieldname'=>'z_m_lastname');
				$ary[] = array('recordid'=>'', 'value'=>$first_name, 'target_fieldname'=>'z_m_firstname');
			}
			
		}
	}else if($target_fieldname == 'z_rd_rdarea_id'){
		$query = "SELECT * FROM vtiger_redemptionareaspp WHERE redemptionareasppid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$prog_partner = $adb->query_result($rs, 0, 'z_rda_progpartner_id');
			$rd_type = $adb->query_result($rs, 0, 'z_rda_rd_type');
			if($rd_type == 'Privilege and Reward') $rd_type = '- Select -';
			
			$query1 = "SELECT * FROM vtiger_programpartners WHERE programpartnersid = ?";
			$rs1 = $adb->pquery($query1,array($prog_partner));
			$rs_rows1 = $adb->num_rows($rs1);
			$ary[] = array('recordid'=>'', 'value'=>$rd_type, 'target_fieldname'=>'z_rd_rd_type');
			
			if ($rs_rows1 > 0){
				$prog_partner_name = $adb->query_result($rs1, 0, 'z_pp_progpartner_id');
				$ary[] = array('recordid'=>$prog_partner, 'value'=>$prog_partner_name, 'target_fieldname'=>'z_rd_progpartner_id_pv');
			}
		}
	}else if($target_fieldname == 'z_rd_reward_id'){
		$query = "SELECT * FROM vtiger_rewards WHERE rewardsid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$rwpts_trans = $adb->query_result($rs, 0, 'z_rw_rwpts_trans');
			$ary[] = array('recordid'=>'', 'value'=>$rwpts_trans, 'target_fieldname'=>'z_rd_redeemedrw_pts');
		}
	}
}else if($current_module == 'Rewards'){
	if($target_fieldname == 'z_rw_progpartner_id'){
		$query = "SELECT * FROM vtiger_programpartners WHERE programpartnersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$program_id = $adb->query_result($rs, 0, 'z_pp_program_id');
			$query1 = "SELECT * FROM vtiger_programs WHERE programsid = ?";
			$rs1 = $adb->pquery($query1,array($program_id));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$program_name = $adb->query_result($rs1, 0, 'z_p_program_id');
				$ary[] = array('recordid'=>$program_id, 'value'=>$program_name, 'target_fieldname'=>'z_rw_program_id');
			}
		}
	}else if($target_fieldname == 'z_rw_progtier_id'){
		$query = "SELECT * FROM vtiger_programtiers WHERE programtiersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$program_id = $adb->query_result($rs, 0, 'z_pt_program_id');
			$query1 = "SELECT * FROM vtiger_programs WHERE programsid = ?";
			$rs1 = $adb->pquery($query1,array($program_id));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$program_name = $adb->query_result($rs1, 0, 'z_p_program_id');
				$ary[] = array('recordid'=>$program_id, 'value'=>$program_name, 'target_fieldname'=>'z_rw_program_id');
			}
		}	
	}
}else if($current_module == 'Privileges'){
	if($target_fieldname == 'z_pv_progpartner_id'){
		$query = "SELECT * FROM vtiger_programpartners WHERE programpartnersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$program_id = $adb->query_result($rs, 0, 'z_pp_program_id');
			$query1 = "SELECT * FROM vtiger_programs WHERE programsid = ?";
			$rs1 = $adb->pquery($query1,array($program_id));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$program_name = $adb->query_result($rs1, 0, 'z_p_program_id');
				$ary[] = array('recordid'=>$program_id, 'value'=>$program_name, 'target_fieldname'=>'z_pv_program_id');
			}
		}
	}else if($target_fieldname == 'z_pv_progtier_id'){
		$query = "SELECT * FROM vtiger_programtiers WHERE programtiersid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			$program_id = $adb->query_result($rs, 0, 'z_pt_program_id');
			$query1 = "SELECT * FROM vtiger_programs WHERE programsid = ?";
			$rs1 = $adb->pquery($query1,array($program_id));
			$rs_rows1 = $adb->num_rows($rs1);
			if ($rs_rows1 > 0) {
				$program_name = $adb->query_result($rs1, 0, 'z_p_program_id');
				$ary[] = array('recordid'=>$program_id, 'value'=>$program_name, 'target_fieldname'=>'z_pv_program_id');
			}
		}	
	}
}



// $ary = array(0=>array('recordid'=>'', 'value'=>99, 'target_fieldname'=>'z_pay_receiptnumber'),
			// 1=>array('recordid'=>'', 'value'=>66, 'target_fieldname'=>'z_pay_amountpaid'),
			// 2=>array('recordid'=>349, 'value'=>"MC00002", 'target_fieldname'=>'z_pay_membershipcards'));

echo "##############BELOWISDATA##############";			
			
echo json_encode($ary);			

?>
