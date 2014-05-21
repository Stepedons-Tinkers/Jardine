<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');
// $mod_names = array('Payments','Billing','HomeOwner','AdvancePayment','MemoAdvice','House','Cars','ReportsKHA','CarLogger');
// $mod_names = array('XMarketingMat');
foreach($mod_names as $mod_name){
	echo "deleting ".$mod_name;
	$module = Vtiger_Module::getInstance($mod_name);
	if($module) {
		$module->delete();
	}
}

?>