<?php
class ModuleDependency	//modules/../EditView.php
						//data/CRMEntity.php
{
	private $moduleDependency = array(
					'XWorkplanEntry'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XWorkplan'=>'z_wpe_workplan',
						'XCustomers'=>'z_wpe_customer'
					),
					'XActivity'=>array(
						'AssignedTo'=>'assigned_user_id',
						'XWorkplan'=>'z_ac_workplan',
						'XWorkplanEntry'=>'z_ac_workplanentry',
						'XCustomers'=>'z_ac_customer'
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
					
	);

	public function __construct(){
	
	}
	
	public function getModuleDependency(){
		return $this->moduleDependency;
	}

	public function getModuleDependency_module($module){
		if(isset($this->moduleDependency[$module]))
			return $this->moduleDependency[$module];
		return false;
	}	
}

?>
