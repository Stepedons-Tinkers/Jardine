<?php
require_once('include/nextixlib/MySMTP.php');

function approveCustomers_notification($entity){
	$currentModule = 'XCustomers';
	$report_arr = explode('x',$entity->id);
	$record = $report_arr[1];

    $focus = CRMEntity::getInstance($currentModule);
    $focus->retrieve_entity_info($record, $currentModule);
    $focus->id  = $record;
	
	$mailer = new MySMTP();
	$subject = "NOTIFICATION: Customer {$focus->column_fields['z_cu_customer']} has been approved";
	$body = "Greetings!<br/>
			<br/>
			I would like to inform you that the customer {$focus->column_fields['z_cu_customer']} has been approved!<br/>
			<br/>
			Thank you!<br/>
			JARDINE-SFA
			";
	$brandassistant = getUsers_roles(array("Brand Assistant / Marketing Service Assistant"));
	$recipient = array();
	foreach($brandassistant as $id => $value){
		$recipient[$value['email1']] = $value['first_name']." ".$value['last_name'];
	}

	// $recipient = array('nextixdeveloper@gmail.com'=>'Test');

	$mailer->revSendDynamicRecipient($subject, $body, $recipient);
}
?>