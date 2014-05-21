<?php
Class DetailModel extends ModelCore
{
    public function __costruct(){
    
    }
    
    public function getDetailTable($id){
    
        $data = array();
        $query = "select * from vtiger_fieldreferencecf where blockid = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
            $data[$i]['blocklabel'] = $this->adb->query_result($result, $i, "blocklabel");
            $data[$i]['blockid'] = $this->adb->query_result($result, $i, "blockid");
            $data[$i]['cornerlabel'] = $this->adb->query_result($result, $i, "cornerlabel");
            $data[$i]['template'] = $this->adb->query_result($result, $i, "template");
        }

        return $data;
    }
    
    public function SingleXSingleY($id){
    
        $data = array();
        $query = "select * from vtiger_fieldreference where blockid = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
			if($this->adb->query_result($result, $i, "column_type") == 0){
				$data[$this->adb->query_result($result, $i, "label1")]
					[$this->adb->query_result($result, $i, "label2")] = $this->adb->query_result($result, $i, "value");
			}
			elseif($this->adb->query_result($result, $i, "column_type") == 1){
				$data[parseLabel($this->adb->query_result($result, $i, "label1"))]
					[$this->adb->query_result($result, $i, "label2")] = $this->adb->query_result($result, $i, "value");
			}
			elseif($this->adb->query_result($result, $i, "column_type") == 2){
				$data[parseLabelSingle($this->adb->query_result($result, $i, "label1"))]
					[$this->adb->query_result($result, $i, "label2")] = $this->adb->query_result($result, $i, "value");
			}
        }
   
        return $data;
        
    }

    public function SingleXDoubleY($id){
    
        $data = array();
        $query = "select * from vtiger_fieldreference where blockid = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
            $data[$this->adb->query_result($result, $i, "label1")]
                    [$this->adb->query_result($result, $i, "label3")]
                        [$this->adb->query_result($result, $i, "label2")] = $this->adb->query_result($result, $i, "value");
        }       
        return $data;
        
    }

    public function DoubleXSingleY($id){
    
        $data = array();
        $query = "select * from vtiger_fieldreference where blockid = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {

            $data[$this->adb->query_result($result, $i, "label1")]
                    [$this->adb->query_result($result, $i, "label2")] 
                        [$this->adb->query_result($result, $i, "label3")] = $this->adb->query_result($result, $i, "value");
        }
        
        return $data;   
    }
    

}


?>