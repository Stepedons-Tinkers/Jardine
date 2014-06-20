<?php
require_once("include/nextixlib/BlockRestriction.php");
// We are using manual adb query, so that if there is block of records, there wont be a problem;
global $adb;

$blockRestriction = new BlockRestriction();
$current_module = $_REQUEST['current_module'];
$recordid = $_REQUEST['recordid'];
$target_fieldname = $_REQUEST['target_fieldname'];

$ary = array();
if($current_module == 'XActivity'){
	if($target_fieldname == 'z_ac_workplanentry'){
		$query = "SELECT * FROM vtiger_xworkplanentry WHERE xworkplanentryid = ?";
		$rs = $adb->pquery($query,array($recordid));
		$rs_rows = $adb->num_rows($rs);
		if ($rs_rows > 0) {
			// $customer = $adb->query_result($rs, 0, 'z_wpe_customer');
			$activitytype = $adb->query_result($rs, 0, 'z_wpe_activitytype');
			$workplan = $adb->query_result($rs, 0, 'z_wpe_workplan');
			
			// $customername = getEntityName('XCustomers',array($customer));
			// $customername = $customername[$customer];
			$activitytypename = getEntityName('XActivityType',array($activitytype));
			$activitytypename = $activitytypename[$activitytype];
			$workplanname = getEntityName('XWorkplan',array($workplan));
			$workplanname = $workplanname[$workplan];
			
			// $ary[] = array('recordid'=>$customer, 'value'=>$customername, 'target_fieldname'=>'z_ac_customer');
			$ary[] = array('recordid'=>$activitytype, 'value'=>$activitytypename, 'target_fieldname'=>'z_ac_activitytype');
			$ary[] = array('recordid'=>$workplan, 'value'=>$workplanname, 'target_fieldname'=>'z_ac_workplan');
		
			$ary[] = $blockRestriction->getBlocksShown_activity($activitytype);
			$forcedisable = $blockRestriction->getDisableField_activity();
			$ary[] = array('recordid'=>'', 'value'=>$forcedisable, 'target_fieldname'=>'forcedisable');
		}
	}
	else if($target_fieldname == 'z_ac_activitytype'){
		$ary[] = $blockRestriction->getBlocksShown_activity($recordid);
		$forcedisable = $blockRestriction->getDisableField_activity();
		$ary[] = array('recordid'=>'', 'value'=>$forcedisable, 'target_fieldname'=>'forcedisable');
	}
}


// $ary = array(0=>array('recordid'=>'', 'value'=>99, 'target_fieldname'=>'z_pay_receiptnumber'),
			// 1=>array('recordid'=>'', 'value'=>66, 'target_fieldname'=>'z_pay_amountpaid'),
			// 2=>array('recordid'=>349, 'value'=>"MC00002", 'target_fieldname'=>'z_pay_membershipcards'));

echo "##############BELOWISDATA##############";			
			
echo json_encode($ary);			

?>
