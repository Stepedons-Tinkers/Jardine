<?php
class ModuleDependency	//modules/../EditView.php
						//data/CRMEntity.php
{
	private $moduleDependency = array(
					'XWorkplanEntry'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XWorkplan'=>'z_wpe_workplan',
						'XCustomers'=>'z_wpe_customer',
						'XActivityType'=>'z_wpe_activitytype'
					),
					'XActivity'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XWorkplan'=>'z_ac_workplan',
						'XWorkplanEntry'=>'z_ac_workplanentry',
						'XCustomers'=>'z_ac_customer',
						'XActivityType'=>'z_ac_activitytype'
					),
					'XJDIMerchCheck'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XActivity'=>'z_jmc_activity'
					),
					'XJDIProductStockCheck'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XActivity'=>'z_jps_activity'
					),
					'XCompProdStockCheck'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XActivity'=>'z_cps_activity'
					),
					'XMarketingIntel'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XActivity'=>'z_min_activity'
					),
					'XProjectRequirement'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XActivity'=>'z_pr_activity'
					),
					'XActivityType'=>array(
					),
					'XCustomers'=>array(
					),
					'XWorkplan'=>array(
					),
					
	);
	
	private $moduleDependency_noFields;

	public function __construct(){
		$this->setModuleDependency_noFields();
	}
	
	public function setModuleDependency_noFields(){
		foreach($this->moduleDependency as $key=>$value){
			if(isset($value['AssignedTo']))
				unset($value['AssignedTo']);
			$this->moduleDespendency_noFields[$key] = $value;
		}
	}
	
	public function getModuleDependency(){
		return $this->moduleDependency;
	}
	
	public function getModuleDependency_noFields(){
		return $this->moduleDespendency_noFields;
	}

	public function getModuleDependency_module($module){
		if(isset($this->moduleDependency[$module]))
			return $this->moduleDependency[$module];
		return false;
	}	
}

?>
