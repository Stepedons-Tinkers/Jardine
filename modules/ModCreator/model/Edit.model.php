<?php
Class EditModel extends ModelCore
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
    
    
    public function updateData($key,$data){
        $query = "update vtiger_fieldreference set value = ? where fieldreferenceid = ?";
        $this->adb->pquery($query,array($data,$key));
        
    }
    
    public function updateLabelCondition($key,$str){
        $query = "update vtiger_fieldreference set label1 = ? where fieldreferenceid = ?";
        $this->adb->pquery($query,array($str,$key));
    }

    public function updateLabel2($key,$str){
        $query = "update vtiger_fieldreference set label2 = ? where fieldreferenceid = ?";
        $this->adb->pquery($query,array($str,$key));

        // #DOUBLE X SINGLE Y
        // $query = "update vtiger_fieldreference set label2 = ? where fieldreferenceid = ?";
        // $this->adb->pquery($query,array($str,$key));
    }   


    public function SingleXSingleY($id){

        $data = array();
        $query = "select * from vtiger_fieldreference where blockid = ?";
        $result = $this->adb->pquery($query,array($id));
        $num_rows = $this->adb->num_rows($result);
        
        for ($i = 0; $i < $num_rows; $i++) {
            if($this->adb->query_result($result, $i, "column_type") == 0){
                $data[$this->adb->query_result($result, $i, "label1")]
                 [$this->adb->query_result($result, $i, "label2")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
             }
            elseif($this->adb->query_result($result, $i, "column_type") == 1){
                $data[parseLabelEdit($this->adb->query_result($result, $i, "label1"),$this->adb->query_result($result, $i, "fieldreferenceid"))]
                 [$this->adb->query_result($result, $i, "label2")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
            }
			elseif($this->adb->query_result($result, $i, "column_type") == 2){
                $data[parseLabelEditSingle($this->adb->query_result($result, $i, "label1"),$this->adb->query_result($result, $i, "fieldreferenceid"))]
                 [$this->adb->query_result($result, $i, "label2")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
        
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
                 [$this->adb->query_result($result, $i, "label2")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
        }       
        return $data;
        
    }

    /*public function DoubleXSingleY($id){
        
            $data = array();
            $query = "select * from vtiger_fieldreference where blockid = ?";
            $result = $this->adb->pquery($query,array($id));
            $num_rows = $this->adb->num_rows($result);
            
            for ($i = 0; $i < $num_rows; $i++) {

                if($this->adb->query_result($result, $i, "column_type") == 0){

                    $data[$this->adb->query_result($result, $i, "label1")]
                            [$this->adb->query_result($result, $i, "label2")] 
                                [$this->adb->query_result($result, $i, "label3")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
                }
                elseif($this->adb->query_result($result, $i, "column_type") == 1){

                    $data[$this->adb->query_result($result, $i, "label1")]
                            [changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "label2"),true )]
                                [$this->adb->query_result($result, $i, "label3")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
                }
            }

            #MANIPULATE ARRAY
            // We have to manipulate array because it will no longer produce the same "threshold" keys, which will not match on the array needed for the result on the DoubleXSingleYSpecial template 

            // To Do ( 2013-02-11 ) : Update the query that will update thresholds for below. Add new code on line 40?

            $data2 = array();

            foreach ($data as $plan_type => $plan_type_arr) 
            {
                $merged_array = array();
                $flag = 0;

                foreach ( $plan_type_arr as $threshold => $value ) 
                {
                    if($flag == 0)
                    {
                        $temp_key = $threshold; #so we can have only one 'threshold' key.
                        $flag = 1;
                    }

                    $merged_array = array_merge($merged_array,$value);

                }
                $data2[$plan_type][$temp_key] = $merged_array; 
            }

            return $data2;   
        }*/

        public function DoubleXSingleY($id){
        
            $data = array();
            $query = "select * from vtiger_fieldreference where blockid = ?";
            $result = $this->adb->pquery($query,array($id));
            $num_rows = $this->adb->num_rows($result);
            
            for ($i = 0; $i < $num_rows; $i++) {

                if($this->adb->query_result($result, $i, "column_type") == 0){

                    $data[$this->adb->query_result($result, $i, "label1")]
                            [$this->adb->query_result($result, $i, "label2")] 
                                [$this->adb->query_result($result, $i, "label3")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
                }
                elseif($this->adb->query_result($result, $i, "column_type") == 1){

                    $data[$this->adb->query_result($result, $i, "label1")]
                            [changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "label2"),true )]
                                [$this->adb->query_result($result, $i, "label3")] = changeToInputType( $this->adb->query_result($result, $i, "fieldreferenceid"),$this->adb->query_result($result, $i, "value") );
                }
            } 
            
            return $data;   
        }

}


?>