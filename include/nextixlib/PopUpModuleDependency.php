<?php
include_once('include/nextixlib/ModuleDependency.php');
class PopUpModuleDependency
{
    private $moduleDependencyClass;
    private $moduleDependency;
    private $memberModules;
    private $programModules;
    private $linkerModules;
	private $request;
	private $query;
	
	private $allvaluedFields = array();
	private $newQuery = '';
	
	private $add_fromclause = '';
	private $add_whereclause = '';
	
	private $recurseDep;
	private $recurseDep_2;
	
    public function __construct(){
		$this->moduleDependencyClass = new ModuleDependency();
		$this->moduleDependency = $this->moduleDependencyClass->getModuleDependency_noFields();
		// $this->memberModules = $this->moduleDependencyClass->getMemberModules();
		// $this->programModules = $this->moduleDependencyClass->getProgramModules();
		// $this->linkerModules = $this->moduleDependencyClass->getLinkerModules();
    }
	
	public function setRequest($request){
		$this->request = $request;
	}

	public function setQuery($query){
		$this->query = $query;
	}
	
	public function checkIfDependentQuery(){
		if($this->request['module'] == 'Users')
			return false;
			
		$parent_module = $this->request['srcmodule'];
		if($parent_module == 'XActivity'){	
			// if(isset($this->moduleDependency[$parent_module]))
				// if(count($this->moduleDependency[$parent_module]) > 1)
					return true;
		}
		
		return false;
	}
	
    public function createFromClause(){
		global $adb;
		
		$valuedFields = array();
		
		$parent_module = $this->request['srcmodule'];
		$parent_record = $this->request['forrecord'];
		
		$this_module = $this->request['module'];

		$uitype10_fields = $this->moduleDependency[$parent_module];
		$this->recurseDep = array();
		
		$this->recurseDep = $this->getRecurseDep($parent_module);
		$this->recurseDep = $this->recurseDep[$parent_module];
		foreach($this->recurseDep as $mod => $valmod){
			$this->recurseDep_2[$mod] = $this->listModsUnderDepMod($valmod);
			$this->recurseDep_2[$mod] = $this->listModsUnderDepMod_clean($this->recurseDep_2[$mod]);
		}
		// echo "<pre>";
		// print_r($this->recurseDep);
		// print_r($this->recurseDep_2);
		// echo "</pre>";

		//this is valued uitype 10
		foreach($uitype10_fields as $dep_mod => $fieldname){
			if(!empty($this->request[$dep_mod]) && $this_module != $dep_mod){
				$valuedFields[] = $dep_mod;			
			}
		}
		$this->allvaluedFields = $valuedFields;
		// print_r($valuedFields);
		//check if value and selected have common
		$common_mod = array();
		foreach($valuedFields as $key => $value){
			if(in_array($this_module, $this->recurseDep_2[$value])){
				$common_mod[$value] = $this_module;
				unset($valuedFields[$key]);
			}
			else if(in_array($value, $this->recurseDep_2[$this_module])){
				$common_mod[$this_module] = $value;
				unset($valuedFields[$key]);
			}
			else{
				foreach($this->recurseDep_2[$this_module] as $value2){
					if(in_array($value2, $this->recurseDep_2[$value])){
						$common_mod[$value] = $value2;
						unset($valuedFields[$key]);
					}					
				}
			}
		}

		// echo "<br/>------Common-----";
		$lineage1 = $lineage2 = array();
		foreach($common_mod as $dep_mod => $common_mod_val){
			if($this_module == $common_mod_val){
				$lineage = $this->getLineageDep($dep_mod,$common_mod_val,$this->recurseDep);
				$lineage = $this->getShortestLineage($lineage);
				
				foreach($lineage as $dep_mod => $dep_mod_value){
					// echo "<br/>LINEAGE-";
					$this->add_fromclause .= $this->addCommonModQuery($dep_mod, $dep_mod_value);
					// echo "<br/><br/><br/>";
				}
			}
			else if($dep_mod == $this_module){	
				//pwede delete or atong e check if naa na ang statement, d e apil. diritso na WHERE
			}
			else{
				$lineage2 = $this->getLineageDep($dep_mod,$common_mod_val,$this->recurseDep);	
				$lineage2 = $this->getShortestLineage($lineage2);
				foreach($lineage2 as $dep_mod2 => $dep_mod_value2){
					// echo "<br/>LINEAGEWW22-";
					$this->add_fromclause .= $this->addCommonModQuery( $dep_mod2,$dep_mod_value2);
					// echo "<br/><br/><br/>";
				}
			}
		}

		// echo $this->query;
		// die();		

    }
	
	public function createWhereClause(){
		foreach($this->allvaluedFields as $mod){
			$mod_lower = strtolower($mod);
			$mod_vtiger = "vtiger_".$mod_lower;
			// if((strstr($this->add_fromclause,$mod_vtiger) !== false) || 
				// (strstr($this->query,$mod_vtiger) !== false))
			$regex = "/{$mod_vtiger}([\s\.\n])/";
			if(preg_match($regex,$this->add_fromclause) ||
				preg_match($regex,$this->query) )
				//remove Reward Program Tier and Program Partner from Reward and Privileges
				// echo "<pre>";
				// print_r($this->request);
				// echo "</pre>";
				$this->add_whereclause .= " AND {$mod_vtiger}.{$mod_lower}id = {$this->request[$mod]} ";
		}
	}
	
	public function manipulateQuery(){
		$select = $from = $where = '';
		$selectQ = $fromQ = $whereQ = '';
		$subquery = 0;
		//get outer select, from, where (problem with search of keywords)
		
		// $test = "SELECT * FROM vsas WHERE asd =a";
		// $test = "SELECT *, (SELECT * FROM asd = 2) as 'asda' FROM vsas WHERE asd =a";
		// $test = "SELECT *, (SELECT * FROM asd = 2 WHERE sdfsd=1)  as 'asda' FROM vsas WHERE asd =a";
		// $test = "SELECT * FROM vsas LEFT JOIN (SELECT * FROM cccc) WHERE asd =a";

		$query = explode(' ', $this->query);
		
		foreach($query as $key => $value){
			$temp = trim($value);
			if($temp){
				if(stristr('SELECT', $temp) !== FALSE || stristr('(SELECT', $temp)){
					if($select === '')
						$select = $key;
					$subquery++;
				}
				else if(stristr('FROM', $temp) !== FALSE){
					if($subquery == 1 && $from === '')
						$from = $key;
					$subquery--;
				}
				else if(stristr('WHERE', $temp) !== FALSE){
					if($subquery == 0 && $where === '')
						$where = $key;		
				}
			}
		}
		
		foreach($query as $key => $value){
			if($key >= $where)
				$whereQ .= $value.' ';
			else if($key >= $from)
				$fromQ .= $value.' ';
			else if($key >= $select)
				$selectQ .= $value.' ';
		}
		
		$fromQ .= $this->add_fromclause;
		$whereQ .= $this->add_whereclause;
		
		// echo "<br/>";
		// echo "<br/>";
		// echo $this->query;
		// echo "<br/>";echo "<br/>";
		// echo $selectQ;
		// echo "<br/>";echo "<br/>";
		// echo $fromQ;
		// echo "<br/>";echo "<br/>";
		// echo $whereQ;
		// echo "<br/>";
		
		$this->newQuery = $selectQ." ".$fromQ." ".$whereQ;
	}	
	
	public function getNewQuery(){
		return $this->newQuery;
	}
	
	public function getAllValuedFields(){
		$data = array();
		foreach($this->allvaluedFields as $mod){
			$data[$mod] = $this->request[$mod];
		}
		return $data;
	}
	
	public function addLinkedModQuery($this_mod, $linker_mod, $dep_mod_val){
		$this_mod_lower = strtolower($this_mod);
		$this_mod_vtiger = "vtiger_".$this_mod_lower;

		if(is_array($dep_mod_val)){		//not tested	//not used
			// echo "LINKER ARRAY";
			if($this_mod == 'RedemptionAreasPP' && isset($dep_mod_val['ProgramPartners'])){
				if(strpos($this->add_fromclause," vtiger_membershipcards ") === false && strpos($this->query," vtiger_membershipcards ") === false){
					$add_query .= " LEFT JOIN vtiger_membershipcards ". 
									"ON vtiger_membershipcards.z_mc_memberid ".
									"= vtiger_members.membersid ";
				}
				if(strpos($this->add_fromclause," vtiger_programpartners ") === false && strpos($this->query," vtiger_programpartners ") === false){
					$add_query .= " LEFT JOIN vtiger_programpartners ". 
									"ON vtiger_programpartners.z_pp_program_id ".
									"= vtiger_membershipcards.z_mc_program ";
				}
				if(strpos($this->add_fromclause," vtiger_redemptionareaspp ") === false && strpos($this->query," vtiger_redemptionareaspp ") === false){
					$add_query .= " LEFT JOIN vtiger_redemptionareaspp ". 
									"ON vtiger_redemptionareaspp.z_rda_progpartner_id ".
									"= vtiger_programpartners.programpartnersid ";
				}
			}
		}
		else{
			$linker_mod_lower = strtolower($linker_mod);
			$linker_mod_vtiger = "vtiger_".$linker_mod_lower;	
			
			
			$this_mod_field = "{$this_mod_lower}id";
			// if(is_array($dep_mod_val))		//added bati solution
				// return '';
			if(isset($this->moduleDependency[$this_mod][$dep_mod_val]))
				$this_mod_field = $this->moduleDependency[$this_mod][$dep_mod_val];			
			$linker_mod_field = "{$linker_mod_lower}id";
			if(isset($this->moduleDependency[$linker_mod][$dep_mod_val]))
				$linker_mod_field = $this->moduleDependency[$linker_mod][$dep_mod_val];

			if(strpos($this->add_fromclause," {$this_mod_vtiger} ") === false && strpos($this->query," {$this_mod_vtiger} ") === false){
				$add_query .= " LEFT JOIN {$this_mod_vtiger} ". 
								"ON {$this_mod_vtiger}.{$this_mod_field} ".
								"= {$linker_mod_vtiger}.{$linker_mod_field} ";
			}
		}
		
		return $add_query;		
	}
	
	public function addCommonModQuery($this_mod, $dep_mod){
		$this_mod_lower = strtolower($this_mod);
		$this_mod_vtiger = "vtiger_".$this_mod_lower;
		
		if(is_array($dep_mod)){	 //used in Redemption, find MembershipCard, given RedemptionArea
			if($this_mod == 'RedemptionAreasPP' && isset($dep_mod['ProgramPartners'])){
				if(strpos($this->add_fromclause," vtiger_programpartners ") === false && strpos($this->query," vtiger_programpartners ") === false){
					$add_query .= " LEFT JOIN vtiger_programpartners ". 
									"ON vtiger_programpartners.z_pp_program_id ".
									"= vtiger_membershipcards.z_mc_program ";
				}
				if(strpos($this->add_fromclause," vtiger_redemptionareaspp ") === false && strpos($this->query," vtiger_redemptionareaspp ") === false){
					$add_query .= " LEFT JOIN vtiger_redemptionareaspp ". 
									"ON vtiger_redemptionareaspp.z_rda_progpartner_id ".
									"= vtiger_programpartners.programpartnersid ";
				}
			}
		}
		else{
			$dep_mod_lower = strtolower($dep_mod);
			$dep_mod_vtiger = "vtiger_".$dep_mod_lower;	
			
			
			$this_mod_field = "{$this_mod_lower}id";
			if(isset($this->moduleDependency[$this_mod][$dep_mod]))
				$this_mod_field = $this->moduleDependency[$this_mod][$dep_mod];			
			$dep_mod_field = "{$dep_mod_lower}id";
			if(isset($this->moduleDependency[$dep_mod][$this_mod]))
				$dep_mod_field = $this->moduleDependency[$dep_mod][$this_mod];

			if(strpos($this->add_fromclause," {$this_mod_vtiger} ") === false && strpos($this->query," {$this_mod_vtiger} ") === false){
				$add_query .= " LEFT JOIN {$this_mod_vtiger} ". 
								"ON {$this_mod_vtiger}.{$this_mod_field} ".
								"= {$dep_mod_vtiger}.{$dep_mod_field} ";
			}
		}
		return $add_query;
	}

	public function getLineageDep($module,$find_mod,$dependencymod){
		if(isset($dependencymod[$module]) && !empty($dependencymod[$module])){
			if(isset($dependencymod[$module][$find_mod])){
				$line[$module] = $find_mod;
			}
			else{
				foreach($dependencymod[$module] as $key => $value){
					$temp = $this->getLineageDep($key,$find_mod,$dependencymod[$module]);
					if(!isset($line[$module]))
						$line[$module] = $temp;
					else
						$line[$module] = array_merge($line[$module],$temp);
				}
			}
		}
		else{
			$line[$module] = array();
		}
		return $line;
	}
	
	public function getShortestLineage($lineage){
		foreach($lineage as $key => $value){
			if(is_array($value)){
				foreach($value as $key2 => $value2){
					$count_lineage[$key2] = 0;
					if(is_array($value2)){
						$count_lineage[$key2] = $this->array_depth($value2);
					}
					else{
						$temp[$key][$key2] = $lineage[$key][$key2];
						return $temp;
					}
				}
				$store_l = 100;
				foreach($count_lineage as $key_l => $value_l){
					if($store_l > $value_l){
						$temp = array();
						$temp[$key][$key_l] = $lineage[$key][$key_l];
						$store_l = $value_l;
					}		
				}
			}
			else{
				$temp = $lineage;
			}
			return $temp;
		}
	}

	public function array_depth(array $array) {
		$max_depth = 1;

		foreach ($array as $value) {
			if (is_array($value)) {
				$depth = $this->array_depth($value) + 1;

				if ($depth > $max_depth) {
					$max_depth = $depth;
				}
			}
		}

		return $max_depth;
	}
	
	public function getRecurseDep($module){
		if(isset($this->moduleDependency[$module]) && !empty($this->moduleDependency[$module])){
			foreach($this->moduleDependency[$module] as $key => $value){
				$sub_sub_dependency = $this->getRecurseDep($key);
				if(!isset($sub_dependency[$module]))
					$sub_dependency[$module] = $sub_sub_dependency;
				else
					$sub_dependency[$module] = array_merge($sub_dependency[$module],$sub_sub_dependency);
			}
		}
		else{
			$sub_dependency[$module] = array();
		}
		return $sub_dependency;
	}
	
	public function listModsUnderDepMod($modsWithDepMode){
		$data = array();
		foreach($modsWithDepMode as $mod => $dependentmods){
			if(is_array($dependentmods)){
				$data[] = $mod;
				$data = array_merge($data,$this->listModsUnderDepMod($dependentmods));
			}
			else
				$data[] = $mod;
		}
		return $data;
	}
	
	public function listModsUnderDepMod_clean($mods){
		$data = array();
		foreach($mods as $value){
			if(!in_array($value,$data))
				$data[] = $value;
		}
		return $data;
	}
	
	public function queryProgramsIDIfPrivilegeReward(){
		global $adb;
		
		foreach($this->allvaluedFields as $key => $value){
			$query = '';
			if($value == 'RedemptionAreasPP'){
				$query = "SELECT z_pp_program_id as `programid` FROM vtiger_programpartners 
						INNER JOIN vtiger_redemptionareaspp ON (vtiger_redemptionareaspp.z_rda_progpartner_id = vtiger_programpartners.programpartnersid) 
						WHERE vtiger_redemptionareaspp.redemptionareasppid = ?";
			}
			else if($value == 'ProgramPartners'){
				$query = "SELECT z_pp_program_id as `programid` FROM vtiger_programpartners 
						WHERE vtiger_programpartners.programpartnersid = ?";
			}
			else if($value == 'MembershipCards'){
				$query = "SELECT z_mc_program as `programid` FROM vtiger_membershipcards 
						WHERE vtiger_membershipcards.membershipcardsid = ?";
			}
			else if($value == 'Members'){
				$query = "SELECT z_mc_program as `programid` FROM vtiger_membershipcards
						INNER JOIN vtiger_members ON vtiger_members.membersid = vtiger_membershipcards.z_mc_memberid
						WHERE vtiger_members.membersid = ?";
			}
			
			$result = $adb->pquery($query,array($this->request[$value]));
			$noofrows = $adb->num_rows($result);
			$data = array();
			if($noofrows) {
				while($row = $adb->fetchByAssoc($result)) {
					$data[] = $row['programid'];
				}
			}
			
			if(!empty($data)){
				$data_str = implode("','",$data);
				return "'{$data_str}'";
			}
			return '';
		}
	}
	
}

?>
