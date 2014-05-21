<?php
Class HomeModel extends ModelCore
{
	public function __costruct(){

	}
	
	public function saveHtmlContaier($html,$module_name,$mode,$record){
		if($mode == 'edit'){
			$query = "update vtiger_modulefileholder set html=?  where id = ?";
			 $this->adb->pquery($query,array(trim($html),$record));
		}
		else{
			$query = "insert into vtiger_modulefileholder (modulename,html) values (?,?)";
			 $this->adb->pquery($query,array($module_name,$html));
		}  
	}
	
	
	
	public function getHtmlContaier($id){
	
		$data = array();
        $query = "select * from vtiger_modulefileholder where id = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
			$html = $this->adb->query_result($result, $i, "html");
        }       
        return html_entity_decode(htmlspecialchars_decode($html));
		
	}

}


?>