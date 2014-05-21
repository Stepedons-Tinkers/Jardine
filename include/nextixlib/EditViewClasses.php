<?php

class EditViewClasses {

	protected $otherModuleBlocks;
	protected $otherModuleBlocks_keyArrays;
	protected $clienttype;

    public function __construct() { 
    }

	public function setOtherModuleBlocks($module,$blocks){
		$this->otherModuleBlocks[$module] = $blocks;
		$this->otherModuleBlocks_keyArrays[$module] = $this->findKeyInBlocks($blocks);
	}
	
	public function setClientType($clienttype){
		$this->clienttype = $clienttype;
	}
	
	public function removingPicklistValue($blocks,$keyArray,$not_included_value_picklist){
		//ed edited, for removing picklist values
		foreach($not_included_value_picklist as $key => $value){
			if(array_key_exists($key, $keyArray)){
				$key1 = $keyArray[$key][0];
				$key2 = $keyArray[$key][1];
				$key3 = $keyArray[$key][2];
				if($blocks[$key1][$key2][$key3][0][0] == 53){	//for Name of Account Officer Agent and Broker 
					$flag = 0;
					$user = array();
					foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
						foreach($picklist as $namekey => $status){
							if($status == 'selected'){
								if($flag == 1){
									$flag = 2;
									break;
								}
								else{
									$flag = 3;
								}
							}
							else if(($flag == 0 || $flag == 3) && !in_array($picklistkey,$not_included_value_picklist[$blocks[$key1][$key2][$key3][2][0]])){
								$user['id'] = $picklistkey;
								$user['name'] = $namekey;
								if($flag == 3){
									$flag = 2;
									break;
								}
								$flag = 1;
							}
						}
						if(in_array($picklistkey,$not_included_value_picklist[$blocks[$key1][$key2][$key3][2][0]])){
							unset($blocks[$key1][$key2][$key3][3][0][$picklistkey]);
							if($flag == 2){
								$blocks[$key1][$key2][$key3][3][0][$user['id']][$user['name']] = 'selected';
							}
						}
					}				
				}
				else{
					foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
						if(in_array($picklist[0],$not_included_value_picklist[$blocks[$key1][$key2][$key3][2][0]])){
							unset($blocks[$key1][$key2][$key3][3][0][$picklistkey]);
						}
					}
				}
			}
		}
		return $blocks;
		//ed edited end
	}
	public function leavingSelectedPicklistValue($blocks,$keyArray,$only_selected_value_picklist){
		//ed edited, for removing picklist values
		foreach($only_selected_value_picklist as $key => $value){
			if(array_key_exists($value, $keyArray)){
				$key1 = $keyArray[$value][0];
				$key2 = $keyArray[$value][1];
				$key3 = $keyArray[$value][2];
				
				foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
					foreach($picklist as $namekey => $status){
						if($status == 'selected'){
							$blocks[$key1][$key2][$key3][3][0] = array($picklistkey => $picklist);
							break;
						}
					}
				}			
			}	
		}		
		return $blocks;
		//ed edited end
	}
	public function leavingSelectedPicklistValueSpecial($blocks,$keyArray,$only_selected_value_picklist,$staffs){
		//ed edited, for removing picklist values
		foreach($only_selected_value_picklist as $key => $value){
			if(array_key_exists($value, $keyArray)){
				$key1 = $keyArray[$value][0];
				$key2 = $keyArray[$value][1];
				$key3 = $keyArray[$value][2];
				$temp = array();
				foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
					foreach($picklist as $namekey => $status){
						if($status == 'selected' || in_array($picklistkey,$staffs)){
							$temp[$picklistkey] = $picklist;
						}
					}
				}	
				$blocks[$key1][$key2][$key3][3][0] = $temp;
			}	
		}		
		return $blocks;
		//ed edited end
	}
	
	//added by Kirstin, to leave values of picklist in a chosen array
	public function leavingSelectedPicklistValue_new($blocks,$keyArray,$only_selected_value_picklist,$picklist_array){
		//ed edited, for removing picklist values
		foreach($only_selected_value_picklist as $key => $value){
			if(array_key_exists($value, $keyArray)){
				$key1 = $keyArray[$value][0];
				$key2 = $keyArray[$value][1];
				$key3 = $keyArray[$value][2];
				$temp = array();
				foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
					if($picklist[2] == 'selected' || in_array($picklist[0],$picklist_array[$value]))
						$temp[] = $picklist;	
				}		
				$blocks[$key1][$key2][$key3][3][0] = $temp;
			}	
		}
		return $blocks;
	}
	
	public function addAndLeaveDashDashPicklistValue($blocks,$keyArray,$makeDashOnlyPicklist){
		//ed edited, for removing picklist values
		foreach($makeDashOnlyPicklist as $key => $value){
			$key1 = $keyArray[$value][0];
			$key2 = $keyArray[$value][1];
			$key3 = $keyArray[$value][2];
			$blocks[$key1][$key2][$key3][3][0] = array();
			$blocks[$key1][$key2][$key3][3][0][''] = array('--'=>'selected');
			
		}	
		return $blocks;
		//ed edited end
	}
	public function removeBlock($blocks,$blockname){
		foreach($blocks as $key => $value){
			if($key == $blockname)
				unset($blocks[$key]);
		}
		return $blocks;
	}
	public function copyPicklistValue($blocks,$keyArray,$copyFrom,$copyTo){
		//ed edited, for copy picklist values
		if(array_key_exists($copyFrom, $keyArray)){
			$key1 = $keyArray[$copyFrom][0];
			$key2 = $keyArray[$copyFrom][1];
			$key3 = $keyArray[$copyFrom][2];
		
			$temp_value = $blocks[$key1][$key2][$key3][3][0];
		}
		if(array_key_exists($copyTo, $keyArray)){
			$key1 = $keyArray[$copyTo][0];
			$key2 = $keyArray[$copyTo][1];
			$key3 = $keyArray[$copyTo][2];
			
			foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
				foreach($picklist as $namekey => $status){
					if($status == 'selected'){
						$blocks[$key1][$key2][$key3][3][0] = $temp_value;			
						$selectedPicklist = $picklistkey;
						break;
					}
				}
			}		
			if(isset($selectedPicklist)){
				foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
					foreach($picklist as $namekey => $status){
						if($picklistkey == $selectedPicklist)
							$blocks[$key1][$key2][$key3][3][0][$picklistkey][$namekey] = 'selected';			
						else
							$blocks[$key1][$key2][$key3][3][0][$picklistkey][$namekey] = '';		
					}
				}				
			}
		}
		return $blocks;
		//ed edited end
	}
	public function findKeyInBlocks($blocks){
		//ed edited, for finding keys
		$keysArray = array();
		foreach($blocks as $key => $value){
			foreach($value as $colkey => $col){
				foreach($col as $rowkey => $row){
					$var = $row[2][0];
					$keysArray[$var] = array($key,$colkey,$rowkey);
				}
			}
		}
		return $keysArray;
		//ed edited end
	}
	
	public function replaceDataAndTransferSelected($blocks,$keyArray,$variable,$newValues){
		$key1 = $keyArray[$variable][0];
		$key2 = $keyArray[$variable][1];
		$key3 = $keyArray[$variable][2];
		$selectedPicklist = '';
		foreach($blocks[$key1][$key2][$key3][3][0] as $picklistkey => $picklist){
			foreach($picklist as $namekey => $status){
				if($status == 'selected'){		
					$selectedPicklist = $picklist;
					
					break;
				}
			}
		}		
		$blocks[$key1][$key2][$key3][3][0] = array();
		$success = false;
		foreach($newValues as $key => $value){
			if($value == $selectedPicklist[0]){
				$blocks[$key1][$key2][$key3][3][0][] = array(0=>$value,1=>$value,2=>'selected');
				$success = true;
			}
			else{
				$blocks[$key1][$key2][$key3][3][0][] = array(0=>$value,1=>$value,2=>'');
			}
		}
		if($success == false){
			if($selectedPicklist[0] != '')
				$blocks[$key1][$key2][$key3][3][0][] = $selectedPicklist;
			else
				$blocks[$key1][$key2][$key3][3][0][0][2] = 'selected';
		}
		return $blocks;
	}
	
	public function removeSelectionFromRelatedField($blocks,$keyArray,$not_included_value_select_related){
		//used in /modules/ModComments/EditView.php
		foreach($not_included_value_select_related as $key => $value){
			if(array_key_exists($key, $keyArray)){
				$key1 = $keyArray[$key][0];
				$key2 = $keyArray[$key][1];
				$key3 = $keyArray[$key][2];

				foreach($blocks[$key1][$key2][$key3][1][0]['options'] as $picklistkey => $picklist){
					if(in_array($picklist,$not_included_value_select_related[$blocks[$key1][$key2][$key3][2][0]])){
						unset($blocks[$key1][$key2][$key3][1][0]['options'][$picklistkey]);
					}
				}
		
			}
		}
		return $blocks;	
	}

	public function rearrangeBlocks($blocks, $block_arrangement){
		foreach($block_arrangement as $blockname){
			$temp[$blockname] = $blocks[$blockname];
			unset($blocks[$blockname]);
			$blocks = array_merge($temp, $blocks);

		}
		return $blocks;
	}	
	
	public function rearrangeFields($blocks, $keyArray, $block_field_arrangement){
		$blocks_orig = $blocks;
		foreach($block_field_arrangement as $blockname=>$row){
			foreach($row as $rowkey => $column){
				foreach($column as $columnkey => $columnname){
					if($columnname == 'CSD ID'){
						$key1 = $this->otherModuleBlocks_keyArrays['CSD']['z_csd_id'][0];
						$key2 = $this->otherModuleBlocks_keyArrays['CSD']['z_csd_id'][1];
						$key3 = $this->otherModuleBlocks_keyArrays['CSD']['z_csd_id'][2];

						$temp[$blockname][$rowkey][$columnname] = $this->otherModuleBlocks['CSD'][$key1][$key2][$key3];				
					}
					else{
						if($columnname == 'cf_1374,cf_612'){		//account size
							if($this->clienttype == 'Corp 51++')
								$columnname = 'cf_612';
							else 
								$columnname = 'cf_1374';
						}
						
						$key1 = $keyArray[$columnname][0];
						$key2 = $keyArray[$columnname][1];
						$key3 = $keyArray[$columnname][2];
						
						$temp[$blockname][$rowkey][$columnname] = $blocks_orig[$key1][$key2][$key3];
						unset($blocks[$key1][$key2][$key3]);
					}
				}
			}
			
			// $blocks[$blockname.'_old'] = $blocks[$blockname];
			unset($blocks[$blockname]);
			$blocks[$blockname] = $temp[$blockname];
		}
		return $blocks;
	}	
	
	public function rearrangeFields_ListStyle($blocks, $keyArray, $field_arrangement){

		$temp = array();
		$blocks_orig = $blocks;
		foreach($field_arrangement as $columnname){
			$key1 = $keyArray[$columnname][0];
			$key2 = $keyArray[$columnname][1];
			$key3 = $keyArray[$columnname][2];
			
			$temp[] = $blocks_orig[$key1][$key2][$key3];
		}
		// echo "<pre>";
		// print_r(array($blocks, $keyArray, $field_arrangement));
		// print_r($temp);
		// echo "</pre>";
		// die();
		return $temp;
	}
}
?>
