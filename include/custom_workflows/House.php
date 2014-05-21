<?php
function updateHouseInfo($entity){
	require_once ("modules/House/House.php");
	require_once ("modules/HomeOwner/HomeOwner.php");
	$house_arr = explode('x',$entity->id);
	$house_id = $house_arr[1];
	

	
	$house_obj = new House();
	$house_obj->setColumns('House');
	$house_obj->id = $house_id;
	$house_obj->retrieve_entity_info($house_id,'House');
	
	if(!empty($house_obj->column_fields['homeowner'])){
		$homeowner_obj = new HomeOwner();
		$homeowner_obj->setColumns('HomeOwner');
		$homeowner_obj->id = $house_obj->column_fields['homeowner'];
		$homeowner_obj->retrieve_entity_info($house_obj->column_fields['homeowner'],'HomeOwner');
		
		if($homeowner_obj->column_fields['primary_house'] == $house_obj->id){
			$homeowner_obj->column_fields['street'] = $house_obj->column_fields['street'];
			$homeowner_obj->column_fields['h_area'] = $house_obj->column_fields['area'];
			$homeowner_obj->column_fields['unit'] = $house_obj->column_fields['unit'];
			$homeowner_obj->mode = 'edit';
			$homeowner_obj->save('HomeOwner');
		}
	}
	
}
?>