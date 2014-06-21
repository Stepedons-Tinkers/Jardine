<?php

class ManipulateAccessControlQuery {	//data/CRMEntity.php ->getNonAdminAccessControlQuery
										//include/nextixlib/NextIXOverwriteRestriction.php

	protected $module;
	protected $userid;
	protected $area;
	protected $rolename;
	protected $current_user_parent_role_seq;

    public function __construct() { 
    }

	public function setModule($module){
		$this->module = $module;
	}

	public function setUser($user){
		$this->userid = $user->id;
		$this->area = $user->area;
		$this->rolename = $user->rolename;
	}

	public function setUser_array($user){
		$this->userid = $user['id'];
		$this->area = $user['area'];
		$this->rolename = $user['rolename'];
	}

	public function setcurrent_user_parent_role_seq($current_user_parent_role_seq){
		$this->current_user_parent_role_seq = $current_user_parent_role_seq;
	}
	
	public function accessCondition(){
		$userrole_1 = array('Regional / Area Sales Manager','SMR');
		$userrole_2 = array('SMR','DIY Supervisor','PCO Supervisor');

		$restrictionType = false;
		if(in_array($this->module, array('XSMR'))){
			if(in_array($this->rolename,$userrole_1)){
				$restrictionType = "HierarchyPeer_Area";
			}
		}
		else if(in_array($this->module, array('XCustomers'))){
			if(in_array($this->rolename,$userrole_1)){
				$restrictionType = "HierarchyPeer_Area_field";
			}
		}
		else if(in_array($this->module, array('XCCPerson','XCustomerProducts'))){
			if(in_array($this->rolename,$userrole_1)){
				$restrictionType = "Customer_field";
			}
		}
		else if(in_array($this->module, array('XSMRTimeCard','XWorkplan','XWorkplanEntry','XActivity','XJDIMerchCheck',
											'XJDIProductStockCheck','XCompProdStockCheck','XMarketingIntel','XProjectRequirement'))){
											
			if(in_array($this->rolename,array('Regional / Area Sales Manager'))){
				$restrictionType = "HierarchyPeer_Area";
			}								
			else if(in_array($this->rolename,$userrole_2)){
				$restrictionType = "Hierarchy";
			}
		}
		return $restrictionType;
	}
	
	public function addQuery(){
		$restrictionType = $this->accessCondition();
		$query = "";
		if($restrictionType == "HierarchyPeer_Area"){
			$query .= $this->setHierarchy_wPeer();
			$query .= $this->setArea();		
		}	
		else if($restrictionType == "HierarchyPeer_Area_field"){
			$query .= $this->setArea_field();		
		}		
		else if($restrictionType == "Hierarchy_Area"){
			$query .= $this->setHierarchy();
			$query .= $this->setArea();	
		}		
		else if($restrictionType == "Hierarchy"){
			$query .= $this->setHierarchy();	
		}		
		else if($restrictionType == "Customer_field"){
			$query .= $this->setCustomer_field();	
		}
		return $query;
	}
	
	public function setHierarchy(){
		$tableName_h = 'vt_tmp_u_h' . $this->userid;
		$query_temp = "(SELECT $this->userid as id) UNION (SELECT vtiger_user2role.userid AS userid FROM " .
				"vtiger_user2role INNER JOIN vtiger_users ON vtiger_users.id=vtiger_user2role.userid " .
				"INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid WHERE " .
				"vtiger_role.parentrole like '$this->current_user_parent_role_seq::%')";

		$query_temp = "create temporary table IF NOT EXISTS $tableName_h(id int(11) primary key) ignore " .
				$query_temp;
		$db = PearDatabase::getInstance();
		$result = $db->pquery($query_temp, array());
		$query = '';
		if (is_object($result)) {
			$query = " INNER JOIN $tableName_h $tableName_h ON $tableName_h.id = " .
			"vtiger_crmentity.smownerid ";
		}					
		return $query;
	}	
	
	public function setHierarchy_wPeer(){
		$tableName_hp = 'vt_tmp_u_hp' . $this->userid;
		$query_temp = "(SELECT $this->userid as id) UNION (SELECT vtiger_user2role.userid AS userid FROM " .
				"vtiger_user2role INNER JOIN vtiger_users ON vtiger_users.id=vtiger_user2role.userid " .
				"INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid WHERE " .
				"vtiger_role.parentrole like '$this->current_user_parent_role_seq%')";

		$query_temp = "create temporary table IF NOT EXISTS $tableName_hp(id int(11) primary key) ignore " .
				$query_temp;
		$db = PearDatabase::getInstance();
		$result = $db->pquery($query_temp, array());
		$query = '';
		if (is_object($result)) {
			$query = " INNER JOIN $tableName_hp $tableName_hp ON $tableName_hp.id = " .
			"vtiger_crmentity.smownerid ";
		}					
		return $query;
	}
	
	public function setArea(){
		// $tableName_a = 'vt_tmp_u_a' . $this->userid;
		
		$query_temp = "SELECT id,z_area FROM vtiger_users
						WHERE status = 'Active'
						AND z_area IS NOT null
						AND z_area != ''";
		$db = PearDatabase::getInstance();
		$result = $db->pquery($query_temp, array());

		$noofrows = $db->num_rows($result);
		$data = array();
		if($noofrows) {
			while($row = $db->fetchByAssoc($result)) {
				$area_temp = explode(' |##| ',$row['z_area']);
				$coArea = array_intersect($area_temp, $this->area);
				if(!empty($coArea))
					$data[] = $row['id'];
			}
		}		
		$query = '';
		if (!empty($data)) {
			$numbers = array();
			foreach($data as $value)
				$numbers[] ="SELECT {$value} AS id";
			$numbers_str = implode(' UNION ', $numbers);
			$query = " INNER JOIN ($numbers_str) user_area_ids ON user_area_ids.id = " .
			"vtiger_crmentity.smownerid ";
		}
		return $query;
	}
	
	public function setArea_field(){
		$query = '';
		if ($this->module == 'XCustomers' && !empty($this->area)) {
			$areas = array();
			foreach($this->area as $value)
				$areas[] ="SELECT '{$value}' AS area";
			$areas_str = implode(' UNION ', $areas);
			$query = " INNER JOIN ($areas_str) user_area ON user_area.area = " .
			"vtiger_xcustomers.z_area ";
		}
		return $query;
	}
	
	public function setCustomer_field(){
		$query = '';
		if ($this->module == 'XCCPerson' && !empty($this->area)) {
			$tableName_c = 'vt_tmp_u_c' . $this->userid;
			$areas = array();
			foreach($this->area as $value)
				$areas[] ="SELECT '{$value}' AS area";
			$areas_str = implode(' UNION ', $areas);
				
			$query_temp = "(SELECT xcustomersid AS id
								FROM vtiger_xcustomers
								INNER JOIN ($areas_str) user_area ON user_area.area = vtiger_xcustomers.z_area)
								";
			$query_temp = "create temporary table IF NOT EXISTS $tableName_c(id int(11) primary key) ignore " .
					$query_temp;
			$db = PearDatabase::getInstance();
			$result = $db->pquery($query_temp, array());
			
			if (is_object($result)) {
				$query = " INNER JOIN $tableName_c $tableName_c ON $tableName_c.id = " .
				"vtiger_xccperson.z_cuc_customer ";
			}		
		}
		else if ($this->module == 'XCustomerProducts' && !empty($this->area)) {
			$tableName_c = 'vt_tmp_u_c' . $this->userid;
			$areas = array();
			foreach($this->area as $value)
				$areas[] ="SELECT '{$value}' AS area";
			$areas_str = implode(' UNION ', $areas);
				
			echo $query_temp = "(SELECT xcustomersid AS id
								FROM vtiger_xcustomers
								INNER JOIN ($areas_str) user_area ON user_area.area = vtiger_xcustomers.z_area)
								";
			$query_temp = "create temporary table IF NOT EXISTS $tableName_c(id int(11) primary key) ignore " .
					$query_temp;
			$db = PearDatabase::getInstance();
			$result = $db->pquery($query_temp, array());
			
			if (is_object($result)) {
				$query = " INNER JOIN $tableName_c $tableName_c ON $tableName_c.id = " .
				"vtiger_xcustomerproducts.z_cp_customer ";
			}		
		}
		return $query;
		
		
		//use this if slow ang taas na query, but changing $mystring
		// $query = '';
		// if ($this->module == 'XCCPerson' && !empty($this->area)) {
			// if(strpos($mystring, 'vtiger_xcustomers') === false){
				// $query = " INNER JOIN vtiger_xcustomers ON vtiger_xcustomers.xcustomersid = vtiger_xccperson.x_cuc_customer ";
			// }
			// $areas = array();
			// foreach($this->area as $value)
				// $areas[] ="SELECT '{$value}' AS area";
			// $areas_str = implode(' UNION ', $areas);
			// $query = " INNER JOIN ($areas_str) user_area ON user_area.area = " .
			// "vtiger_xcustomers.z_area ";
		// }
		// return $query;
	}
	
}
?>
