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
			if(!empty($recOwnId)){
				require('user_privileges/user_privileges_'.$recOwnId.'.php');
				$this->recuser_info = $user_info;
				$this->reccurrent_user_parent_role_seq = $current_user_parent_role_seq;
			}
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
		else if(in_array($restrictionType, array("Customer_field"))){
			if ($this->module == 'XCCPerson') {
				if($this->record_id != ''){
					$focus_this = CRMEntity::getInstance($this->module);
					$focus_this->id = $this->record_id;
					$focus_this->retrieve_entity_info($this->record_id, $this->module);
						
					$focus_customer = CRMEntity::getInstance('XCustomers');
					$focus_customer->id = $focus_this->column_fields['z_cuc_customer'];
					$focus_customer->retrieve_entity_info($focus_customer->id, 'XCustomers');
					$area_temp = explode(' |##| ',$focus_customer->column_fields['z_area']);
					$coArea = array_intersect($area_temp, $this->current_user->area);
					if(empty($coArea))
						$permission = "no";							
				}
			}	
			else if ($this->module == 'XCustomerProducts') {
				if($this->record_id != ''){
					$focus_this = CRMEntity::getInstance($this->module);
					$focus_this->id = $this->record_id;
					$focus_this->retrieve_entity_info($this->record_id, $this->module);
						
					$focus_customer = CRMEntity::getInstance('XCustomers');
					$focus_customer->id = $focus_this->column_fields['z_cuc_customer'];
					$focus_customer->retrieve_entity_info($focus_customer->id, 'XCustomers');
					$area_temp = explode(' |##| ',$focus_customer->column_fields['z_area']);
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

	public function permRemoveAllFunctionality(){	//except detail and index
		$permission = false;
		if(!in_array($this->actionid, array(0,3,4)))
			$permission = "no";
		return $permission;
	}
}

?>
