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


?>