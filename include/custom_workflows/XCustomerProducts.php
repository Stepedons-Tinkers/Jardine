<?php
function activateCustomerProducts($entity){
	$currentModule = 'XCustomerProducts';
	$report_arr = explode('x',$entity->id);
	$record = $report_arr[1];

    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$focus->column_fields['z_cp_isactive'] = '1';
	$focus->mode = "edit";	
	$focus->save($currentModule);
}
function deactivateCustomerProducts($entity){
	$currentModule = 'XCustomerProducts';
	$report_arr = explode('x',$entity->id);
	$record = $report_arr[1];

    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$focus->column_fields['z_cp_isactive'] = '';
	$focus->mode = "edit";	
	$focus->save($currentModule);
}
?>