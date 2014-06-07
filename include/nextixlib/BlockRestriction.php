<?php
class BlockRestriction{
	private $blocksShown;
	private $relatedblocksShown;
	
	public function __construct(){
	
	}
	
	public function getBlocksShown_activity($activity_record){
		//get Activity Type Data
		$activity_mod = 'XActivityType';
		
		$focus_activity = CRMEntity::getInstance($activity_mod);
		$focus_activity->retrieve_entity_info($activity_record, $activity_mod);
		$focus_activity->id  = $activity_record;			
		$z_act_activitytype = $focus_activity->column_fields['z_act_activitytype'];
		$z_act_acttypcat = $focus_activity->column_fields['z_act_acttypcat'];
		
		$blocksShown = array('General Information');
		if(in_array($z_act_activitytype, array('Retail Visits (Traditional Hardware)','Retail Visit (Merienda)')))
			array_push($blocksShown,'Retail Visit');
		// else if(in_array($z_act_activitytype, array('Sub-Dealer / Wholesaler Visit','Dealer Depot Visits')))	
			// array_push($blocksShown,'Dealer Visit');
		else if(in_array($z_act_activitytype, array('DIY Visits','Supermarket Visits')))	
			array_push($blocksShown,'DIY or Supermarket');
		else if(in_array($z_act_activitytype, array('Company Work-with Co-SMR/ Supervisor')))	
			array_push($blocksShown,'With CoSMRs');
		else if(in_array($z_act_acttypcat, array('Training')))	
			array_push($blocksShown,'Trainings');
		
		$this->blocksShown = $blocksShown;
		
		//related
		$relatedblocksShown = array('JDI Product Stock Check','JDI Merchandising Check','Competitor Product Stock Check','Marketing Intel','Project Requirement','Customer Contact Person');
		if(in_array($z_act_activitytype, array('End-User Visit - Homeowners High-End', 'End-User Visit - Homeowners Middle Class'))){
			array_push($relatedblocksShown,'Products');
		}
		else if(in_array($z_act_activitytype, array('DIY Visits','Supermarket Visits'))){
			array_push($relatedblocksShown,'DIY or Supermarket Photos');
		}
		$this->relatedblocksShown = $relatedblocksShown;
		
		$ary = array('recordid'=>'', 'value'=>$blocksShown, 'target_fieldname'=>'blocksShown');
		return $ary;
	}
	
	public function getRelatedblocksShown(){
		return $this->relatedblocksShown;
	}
}


?>