<?phpfunction activateProduct($entity){	$currentModule = 'XProduct';	$report_arr = explode('x',$entity->id);	$record = $report_arr[1];    $focus = CRMEntity::getInstance($currentModule);    $focus->retrieve_entity_info($record, $currentModule);    $focus->id  = $record;		$focus->column_fields['z_prd_isactive'] = '1';	$focus->mode = "edit";		$focus->save($currentModule);}function deactivateProduct($entity){	$currentModule = 'XProduct';	$report_arr = explode('x',$entity->id);	$record = $report_arr[1];    $focus = CRMEntity::getInstance($currentModule);    $focus->retrieve_entity_info($record, $currentModule);    $focus->id  = $record;		$focus->column_fields['z_prd_isactive'] = '';	$focus->mode = "edit";		$focus->save($currentModule);}?>