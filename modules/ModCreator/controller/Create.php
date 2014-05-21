<?php
class Create extends ControllerCore
{
	public function __construct(){

	}
	
	public function __initialize(){
		$this->style('listview');
		$this->setModel('Create');
	}
	
	public function index(){
	
		$data = array('hello','bye','test');
		
		$this->template('Common/Header',$data);
		$this->template('Create/Container');
		$this->template('Common/Footer',$data);
		
	}
	
	public function save(){
		
		$this->create->save($_REQUEST['survey_name']);
		
		echo "{####???###}";
		echo $this->create->getLastID();
		echo "{####???###}";
	}
	
}

?>