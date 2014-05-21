<?php
Class ListViewModel extends ModelCore
{
    public function __costruct(){
    
    }
    
    public function getAllTables(){
    
        $data = array();
        $query = "select * from vtiger_modulefileholder where modulename != 'Default'";
        $result = $this->adb->pquery($query,array());
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
            $data[$i]['id']     = $this->adb->query_result($result, $i, "id");
            $data[$i]['modulename']        = $this->adb->query_result($result, $i, "modulename");
        }
        
        return $data;
    }

    

}


?>