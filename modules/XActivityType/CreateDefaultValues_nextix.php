<?php
global $current_user, $currentModule;

if($current_user->id == 7){
	$defaultAcitvityType = array(
		'Retail Visits (Traditional Hardware)' => 'Visit',
		'Retail Visit (Merienda)' => 'Visit',
		'Sub-Dealer / Wholesaler Visit' => 'Visit',
		'Dealer Depot Visits' => 'Visit',
		'DIY Visits' => 'Visit',
		'Supermarket Visits' => 'Visit',
		'PCO Visits' => 'Visit',
		'KI Visits - Office' => 'Visit',
		'KI Visits - On-site' => 'Visit',
		'End-User Visit - Homeowners High-End' => 'Visit',
		'End-User Visit - Homeowners Middle Class' => 'Visit',
		'HRI' => 'Visit',
		'TODA' => 'Visit',
		'Barangay' => 'Visit',
		'Others' => 'Visit',
		'Sash Factory Visit' => 'Visit',
		'Major Training - CSS Nights' => 'Training',
		'Major Training - CFN' => 'Training',
		'Major Training - Specifiers Night' => 'Training',
		'Major Training - PCO Conference' => 'Training',
		'Major Training - Exhibit Implementation' => 'Training',
		'Minor Training - DIY Training' => 'Training',
		'Minor Training - Dealer Staff Training' => 'Training',
		'Minor Training - Sub-Dealer / Wholesaler Training' => 'Training',
		'Minor Training - PCO Training' => 'Training',
		'Minor Training - Customer / Mall Workshops' => 'Training',
		'Minor Training - KI Office Presentation ' => 'Training',
		'Minor Training - On-site Presentation' => 'Training',
		'Minor Training - Retail Merienda Training' => 'Training',
		'End User Training - Homeowners High-End' => 'Training',
		'End User Training - Middle Class' => 'Training',
		'End User Training - HRI' => 'Training',
		'End User Training - TODA' => 'Training',
		'End User Training - Barangay' => 'Training',
		'End User Training - Others (has remarks)' => 'Training',
		'End User Activity - Leafleting' => 'Training',
		'End User Activity - Market Selling' => 'Training',
		'End User Activity - Product Detailing ' => 'Training',
		'Sash Factory Training' => 'Training',
		'Exhibit Manning' => 'Training',
		'Full Brand Activation' => 'Others',
		'Company Work-with Field Promo Specialist' => 'Others',
		'Company Work-with Co-SMR/ Supervisor' => 'Others',
		'Non-JDI Work With' => 'Others',
		'Travel' => 'Others',
		'Waiting' => 'Others',
		'Admin Work' => 'Others'
	);

	foreach($defaultAcitvityType as $activity_type => $activity_type_categorization){
		$focus = CRMEntity::getInstance($currentModule);
		$focus->column_fields['z_act_activitytype'] = $activity_type;
		$focus->column_fields['z_act_acttypcat'] = $activity_type_categorization;
		$focus->column_fields['z_act_active'] = 1;
		$focus->column_fields['assigned_user_id'] = 7;

		$focus->mode = "";	
		$focus->save($currentModule);
	}
}
header("Location: index.php?module=XActivityType&action=index");

?>