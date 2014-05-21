<?php
class Edit extends ControllerCore
{
    public function __construct(){

    }
    
    public function __initialize(){
        $this->style('listview');
        $this->setModel('Edit');
        $this->setUtility('utilities');
        $this->addLibrary('tables/TableTemplating');
        $this->tableobj = new TableTemplating($this->dirPath);
    }
    
    public function index(){
    
        $this->template('Common/Header');
        $this->template('Edit/Container');
        
    }
    
    public function edit(){
    
         if(isset($_REQUEST['record']))
            $this->id = $_REQUEST['record'];


        // echo "<pre>";
        // echo print_r($this);
        // echo "</pre>";
            
        $data['id'] = $this->id;
        $data['data'] = $this->edit->getDetailTable($this->id);
        $this->tableobj->setDisplay($data['data'][0]['template']);
        $data['fields'] = $this->edit->$data['data'][0]['template']($this->id);
                     
        $data['table'] = $this->tableobj->getDisplay()->generateDisplay($data,'detail');
        
        $this->template('Common/Header');
        $this->template('Edit/Container',$data);
    }
    
    public function save(){
        global $currentModule;
        global $adb;

        $timestamp = date('Y-m-d H:i:s');

        foreach($_REQUEST as $key => $value){
            if(is_numeric($key)){    
                logModifications( $key, $_REQUEST[$key], "value", $timestamp, $adb );            
                $this->edit->updateData($key,$_REQUEST[$key]);               
            }
            // elseif (preg_match('/label_/',$key)) {
            //     $tyep2_temp = explode('_',$key);
            //     logModifications( $key, $tyep2_temp[1], "label", $timestamp, $adb );  
            //     $this->edit->updateLabel2($tyep2_temp[1],$_REQUEST[$key]);
            // }
            elseif(preg_match('/condition_/',$key)){ // echo "<h2>255555</h2>";
                $tyep2_temp = explode('_',$key);               
                $type2[$tyep2_temp[1]][$tyep2_temp[2]."_".$tyep2_temp[3]] = $value;
            }
            elseif(preg_match('/single_/',$key)){
                $single_temp = explode('_',$key);
                $single[$single_temp[1]] = $value;   
            }
        }


        if(isset($type2)) {

            foreach($type2 as $key => $value){
                $str = '{';
                $i = 1;
                foreach($value as $key2 => $value2){
                    $str .= '"condition'.$i.'":'.'"'.$key2.'",';
                    $str .= '"value'.$i.'":'.'"'.$value2.'",';
                    $i++;
                }
                $str = substr($str,0,-1);
                $str .= '}';

                logModifications( $key, $str, "label1", $timestamp, $adb );  
                $this->edit->updateLabelCondition($key,$str);
            }
        }
            
        if(isset($single)) {

            foreach($single as $key => $value){
            
                $str = '{';
                $str .= '"value1":'.'"'.$value.'",';
                $str = substr($str,0,-1);
                $str .= '}';
                
                logModifications( $key, $str, "label1", $timestamp, $adb );  
                $this->edit->updateLabelCondition($key,$str);
            }
        }
        
        redirect($currentModule,"Detail","view",$_REQUEST['recordid']);
    }
    
}

?>