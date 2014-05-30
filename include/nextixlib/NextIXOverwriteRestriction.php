<?php
// if(class_exists('QuotationUserDisplayType') != true)
	// require_once('include/maxicarelib/QuotationUserDisplayType.php');	
// if(class_exists('GroupedModules') != true)
	// require_once('include/nextixlib/GroupedModules.php');	
if(class_exists('ManipulateAccessControlQuery') != true)
	require_once('include/nextixlib/ManipulateAccessControlQuery.php');	
	
class NextIXOverwriteRestriction		//used in util/UserInfoUtil.php
{
    private $module;
	private $actionname;
	private $actionid;
	private $record_id;
	private $adb;
	private $current_user;
	private $recuser_info;
	private $reccurrent_user_parent_role_seq;
	
	private $macq;

    public function __construct($module,$actionname,$actionid,$record_id,$adb,$current_user){
		$this->module = $module;
		$this->actionname = $actionname;
		$this->actionid = $actionid;
		$this->record_id = $record_id;
		$this->adb = $adb;
		$this->current_user = $current_user;
		
		$this->user_info='';
		$this->current_user_parent_role_seq='';
		if($this->record_id != ''){
			$recordOwnerArr = getRecordOwnerId($this->record_id);
			foreach($recordOwnerArr as $type=>$id)
			{
				$recOwnId=$id;
			}
			require('user_privileges/user_privileges_'.$recOwnId.'.php');
			$this->recuser_info = $user_info;
			$this->reccurrent_user_parent_role_seq = $current_user_parent_role_seq;
		}
    }

	public function permissionStatic(){
		$this->macq = new ManipulateAccessControlQuery();
		$this->macq->setModule($this->module);
		$this->macq->setUser($this->current_user);
		
		// $groupedModules = new GroupedModules();
		$mod_func = 'perm'.$this->module;
		// //ALL
		// if($this->module == 'NextIXfunctions'){
			// return "yes";
		// }
		// if($this->actionname == 'Popup'){
			// return "yes";
		// }
		// //ALL end		
		if(method_exists($this,$mod_func)){
			if($this->current_user->isSupreme)	//supreme admins
				return "yes";
			return $this->$mod_func();		//calls module Permission
		}
		// else if($groupedModules->checkByNameIfLog($this->module)){
			// return $this->permRemoveAllFunctionality();
		// }
		else{
			return false;
		}
		return false;
	}
	
	public function permXSMRTimeCard(){
		$permission = false;
		if($this->actionname == 'EditView'){
			if($this->record_id != ''){	//edit
				if(!in_array($this->current_user->rolename,array('User Maintenance Admin')))
					$permission = "no";	
			}
			else{	//create
				if(!in_array($this->current_user->rolename,array('Regional / Area Sales Manager','SMR','DIY Supervisor','PCO Supervisor')))
					$permission = "no";					
			}
		}
		return $permission;
	}
	
	public function permXWorkplan(){
		$permission = false;

		return $permission;
	}
	
	public function checkAreaRestriction(){
		$restrictionType = $this->macq->accessCondition();
		$permission = false;
		if(in_array($restrictionType, array("HierarchyPeer_Area","Hierarchy_Area"))){
			if($this->record_id != ''){
				$area_temp = explode(' |##| ',$this->recuser_info['z_area']);
				$coArea = array_intersect($area_temp, $this->current_user->area);
				if(empty($coArea))
					$permission = "no";	
			}
		}		
		else if(in_array($restrictionType, array("HierarchyPeer_Area_field"))){
			if ($this->module == 'XCustomers') {
				if($this->record_id != ''){
					$focus_this = CRMEntity::getInstance($this->module);
					$focus_this->id = $this->record_id;
					$focus_this->retrieve_entity_info($this->record_id, $this->module);
					$area_temp = explode(' |##| ',$focus_this->column_fields['z_area']);
					$coArea = array_intersect($area_temp, $this->current_user->area);
					if(empty($coArea))
						$permission = "no";	
				}
			}			
		}
		return $permission;
	}
	
	public function manipulateOtherPermission($others_permission_id){
		$restrictionType = $this->macq->accessCondition();
		if($restrictionType == "HierarchyPeer_Area"){
			if($this->record_id != ''){
				$current_user_parent_role_seq_arr = explode('::',$this->reccurrent_user_parent_role_seq);
				if(!in_array($this->current_user->roleid,$current_user_parent_role_seq_arr))
					$others_permission_id = "no";
				// else
					// $others_permission_id = "yes";
			}
		}		
		else if(in_array($restrictionType, array("Hierarchy_Area","Hierarchy"))){
			$others_permission_id = 3;
		}
		return $others_permission_id;
	}
	
	/*
	public function permMembershipCards(){
		// echo $this->actionname;
		// echo $this->real_action;
		// echo "<pre>";
		// print_r($_REQUEST);
		// echo "</pre>";
		
		$allow = false;
		if(isset($_REQUEST['version']) && in_array($_REQUEST['version'],array('Replacement','Renew')))
			$allow = true;
		else if(isset($_REQUEST['tierupgrade']) && in_array($_REQUEST['tierupgrade'],array('Approve','Disapprove')))
			$allow = true;
		
		$permission = false;
		if($this->actionname == 'EditView' && $this->real_action != 'CreateView' && !$allow)		//only Edit Restriction
			$permission = "no";
		return $permission;
	}

	public function permProgramMembershipFees(){
		// echo $this->module;
		// echo $this->actionname;
		// echo $this->real_action;
		// echo $this->record_id;
		// echo "<pre>";
		// print_r($_REQUEST);
		// echo "</pre>";
		
		$permission = false;
		if($this->actionname == 'EditView' && $this->record_id != ''){
			$focus_this = CRMEntity::getInstance($this->module);
			$focus_this->id = $this->record_id;
			$focus_this->retrieve_entity_info($this->record_id, $this->module);
			
			$focus_programs = CRMEntity::getInstance('Programs');
			$focus_programs->id = $focus_this->column_fields['z_pmf_program_id'];
			$focus_programs->column_fields = array();
			$focus_programs->retrieve_entity_info($focus_this->column_fields['z_pmf_program_id'], "Programs");	

			$allow = false;
			if($focus_programs->column_fields['z_p_activated'] != 1){
				$permission = "no";
			}
		}	

		return $permission;
	}

	public function permPoints(){

		$membershipdata = getMembershipData_pointsid($_REQUEST['record']);		//CommonUtils.php
		$allow = false;
		if($membershipdata['z_mc_membershipcardstatus'] != 'Deactivated')
			$allow = true;

		$permission = false;
		if($this->actionname == 'EditView' && $this->record_id != '' && !$allow)		//only Edit Restriction
			$permission = "no";
		return $permission;
	}
	*/
	/*	
	public function permQuotation(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$role = $quotationUserDisplayType->getRole();
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();

		$notRestrictDelete = array(); //array('Actuarial Supervisor','Actuarial Assistant Manager','Actuarial Manager');	//nobody could delete quotation

		$permission = false;
		if($user_role_group == 'Admin'){
			//weird ang saving functionality. mo change to 1 ang currentuser:
			//$em->triggerEvent("vtiger.entity.aftersave", $entityData);		//CRMEntity.php
		}
		else if($user_role_group == 'ACT' || ($user_role_group == 'NONE' && $role == 'President')){
			if($this->actionid == '10' || $this->actionid == '2'){	//Duplicate Delete
				$permission = "no";
			}
		}
		else{
			if($this->actionid != '0'){	//all except save				//vtiger_actionmapping
				$permission = "no";
			}
		}
		
		// if($this->actionid == '10'){		//Duplicate
			// $permission = "no";
			
		// }
		// else if($this->actionid == '2' && !in_array($user_role,$notRestrictDelete)){	//Delete
			// $permission = "no";
		// }	
		return $permission;
	}
	
	public function permRateSheet(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();

		$notRestrictDelete = array(); //array('Actuarial Supervisor','Actuarial Assistant Manager','Actuarial Manager');	//nobody could delete quotation

		$permission = false;
		if($user_role_group == 'Admin'){
			//weird ang saving functionality. mo change to 1 ang currentuser:
			//$em->triggerEvent("vtiger.entity.aftersave", $entityData);		//CRMEntity.php
		}
		else{
			if($this->actionid == '10' || $this->actionid == '2'){	//Duplicate Delete
				$permission = "no";
			}
		}
		return $permission;
	}	

	public function permCSD(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();
		
		$permission = false;
		if(in_array($this->actionid, array('10','2','1'))){	//Duplicate Delete Edit
			$permission = "no";
		}		

		return $permission;
	}
	
	public function permCommissionMaintenance(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();
		
		$permission = false;
		if(in_array($this->actionid, array('10','2'))){	//Duplicate Delete Edit
			$permission = "no";
		}		
		if($user_role_group == 'Admin' && in_array($this->actionid, array('10','2'))){
			$permission = 'yes';
		} 		
		return $permission;
	}
	
	
	public function permOtherArrangements(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();
		
		$permission = false;
		if(in_array($this->actionid, array('10','2'))){	//Duplicate Delete Edit
			$permission = "no";
		}		
		if($user_role_group == 'Admin' && in_array($this->actionid, array('10','2'))){
			$permission = 'yes';
		} 

		return $permission;
	}
	
	public function permCSDRevisionRequest(){
		$quotationUserDisplayType = new QuotationUserDisplayType();
		$quotationUserDisplayType->setUser_role($this->current_user->id);
		$user_role = $quotationUserDisplayType->getUser_role();
		$user_role_group = $quotationUserDisplayType->getUser_role_group();
		
		$permission = false;
		if($user_role_group != 'AO' && $user_role_group != 'Admin'){
			if($this->actionid == '1')		//Edit
				$permission = "no";
		}
		if($this->actionid == '10' || $this->actionid == '2'){	//Duplicate Delete
			$permission = "no";
		}		

		return $permission;
	}
	*/
	public function permRemoveAllFunctionality(){	//except detail and index
		$permission = false;
		if(!in_array($this->actionid, array(0,3,4)))
			$permission = "no";
		return $permission;
	}
}

?>
