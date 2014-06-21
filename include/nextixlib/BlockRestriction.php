<?php
class BlockRestriction{
	private $blocksShown;
	private $relatedblocksShown;
	
	private $z_act_activitytype;
	private $z_act_acttypcat;
	
	public function __construct(){
	
	}
	
	public function getRelatedblocksShown(){
		return $this->relatedblocksShown;
	}

	public function getBlocksShown_activity($activity_record){
		//get Activity Type Data
		$activity_mod = 'XActivityType';
		
		$focus_activity = CRMEntity::getInstance($activity_mod);
		$focus_activity->retrieve_entity_info($activity_record, $activity_mod);
		$focus_activity->id  = $activity_record;			
		$this->z_act_activitytype = $focus_activity->column_fields['z_act_activitytype'];
		$this->z_act_acttypcat = $focus_activity->column_fields['z_act_acttypcat'];
		
		$blocksShown = array('General Information');
		if(in_array($this->z_act_activitytype, array('Retail Visits (Traditional Hardware)','Retail Visit (Merienda)')))
			array_push($blocksShown,'Retail Visit');
		// else if(in_array($this->z_act_activitytype, array('Sub-Dealer / Wholesaler Visit','Dealer Depot Visits')))	
			// array_push($blocksShown,'Dealer Visit');
		else if(in_array($this->z_act_activitytype, array('DIY Visits','Supermarket Visits')))	
			array_push($blocksShown,'DIY or Supermarket');
		else if(in_array($this->z_act_activitytype, array('Company Work-with Co-SMR/ Supervisor')))	
			array_push($blocksShown,'With CoSMRs');
		else if(in_array($this->z_act_activitytype, array('KI Visits - On-site')))	
			array_push($blocksShown,'Project Visit');
		else if(in_array($this->z_act_acttypcat, array('Training')))	
			array_push($blocksShown,'Trainings');
		
		$this->blocksShown = $blocksShown;
		
		//related
		$relatedblocksShown = array('Marketing Intel','Customer Contact Person');
		if(in_array($this->z_act_activitytype, array('End-User Visit - Homeowners High-End', 'End-User Visit - Homeowners Middle Class'))){
			array_push($relatedblocksShown,'Products');
		}
		else if(in_array($this->z_act_activitytype, array('DIY Visits','Supermarket Visits'))){
			array_push($relatedblocksShown,'DIY or Supermarket Photos');
		}
		else if(in_array($this->z_act_activitytype, array('Retail Visits (Traditional Hardware)','Retail Visit (Merienda)'))){
			array_push($relatedblocksShown,'JDI Product Stock Check','JDI Merchandising Check','Competitor Product Stock Check');
		}
		else if(in_array($this->z_act_activitytype, array('KI Visits - On-site','KI Visits - Office'))){
			array_push($relatedblocksShown,'Project Requirement');
		}
		$this->relatedblocksShown = $relatedblocksShown;
		
		$ary = array('recordid'=>'', 'value'=>$blocksShown, 'target_fieldname'=>'blocksShown');
		return $ary;
	}
	
	public function getDisableField_activity($forcedisable=array()){
		$manipulate_forcedisable_fields = array('z_ac_othersacttypermrk','z_ac_reasonremarks','z_ac_details');
		foreach($manipulate_forcedisable_fields as $value){
			if(!in_array($value,$forcedisable))
				$forcedisable[] = $value;
		}

		if(in_array($this->z_act_activitytype, array('Others'))){
			$forcedisable = array_diff($forcedisable,array('z_ac_othersacttypermrk'));
		}
		else if(in_array($this->z_act_activitytype, array('Waiting','Travel'))){
			$forcedisable = array_diff($forcedisable,array('z_ac_reasonremarks'));
		}
		else if(in_array($this->z_act_activitytype, array('Admin Work'))){
			$forcedisable = array_diff($forcedisable,array('z_ac_details'));
		}
		return $forcedisable;
	}

	public function getBlocksShown_customer($z_cu_customertype){
		//related
		$relatedblocksShown = array('Customer Contact Person');
		if(in_array($z_cu_customertype, array('Dealer', 'Sub-dealer', 'General Trade', 'Modern Trade'))){
			array_push($relatedblocksShown,'Customer Products');
		}

		$this->relatedblocksShown = $relatedblocksShown;
	}	
}


?>