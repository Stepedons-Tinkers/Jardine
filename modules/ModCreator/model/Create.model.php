<?php
Class CreateModel extends ModelCore
{
	public function __costruct(){
	
	}
	
	public function save($survey_name){
		$query = "insert into survey (survey_name) values(?)";
		$this->adb->pquery($query,array($survey_name));
		$this->last_id = $this->adb->getLastInsertID();
	}
	
	public function getLastID(){
		
		return $this->last_id;
	
	}
	

}


?>