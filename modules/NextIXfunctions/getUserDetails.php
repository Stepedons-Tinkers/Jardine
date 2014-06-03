<?php
$function = $_REQUEST['thisModule']."_assignedto";
$function();	

function XSMR_assignedto(){
	$userid = $_REQUEST['assignedto'];
	
	$userdetails = getUserDetails_id(array($userid));

	$data = array();
	foreach($userdetails as $id => $value){
		$data = $value;
		break;
	}
	
	echo "___THIS_IS_THE_INDICATOR___";
	echo json_encode($data);	
}

function XWorkplanEntry_assignedto(){
	$userid = $_REQUEST['assignedto'];
	
	$userdetails = getUserDetails_id(array($userid));

	$data = array();
	foreach($userdetails as $id => $value){
		$data = $value;
		break;
	}
	echo "___THIS_IS_THE_INDICATOR___";
	if($data['rolename'] == 'SMR')
		echo json_encode($data);	
	else{
		$data['area'] = getAreas(array('- Select -'));
		echo json_encode($data);
	}
}


?>