<?php
class Cron
{
    protected $new_z_cuc_daysunchanged;

    public function __construct(){
	
    }

	public function ccperson_daysUnchanged(){
		global $adb;
		$query = "SELECT * FROM vtiger_xccperson
					INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_xccperson.xccpersonid
					WHERE vtiger_crmentity.deleted = 0;";
		$result = $adb->pquery($query,array());
		$noofrows = $adb->num_rows($result);
		$data = array();
		if($noofrows) {
			while($resultrow = $adb->fetchByAssoc($result)) {
				$this->ccperson_edit_daysUnchanged($resultrow);
				
				if($this->new_z_cuc_daysunchanged == 60){
					$this->ccperson_add_todo($resultrow);
				}
			}
		}	
	}
	
	public function ccperson_edit_daysUnchanged($resultrow){
		$currentModule = 'XCCPerson';
		$this_obj = CRMEntity::getInstance($currentModule);
		$this_obj->retrieve_entity_info($resultrow['xccpersonid'], $currentModule);
		$this_obj->id  = $resultrow['xccpersonid'];
		$this->new_z_cuc_daysunchanged =  $resultrow['z_cuc_daysunchanged'] + 1;
		$this_obj->column_fields['z_cuc_daysunchanged'] = $this->new_z_cuc_daysunchanged;
		$this_obj->mode = "edit";	
		$this_obj->save($currentModule);		
	}
	
	public function ccperson_add_todo($resultrow){
		require_once('modules/Calendar/Activity.php');
		require_once('modules/Calendar/CalendarCommon.php');
		require_once('include/logging.php');
		require_once("config.php");
		require_once('include/database/PearDatabase.php');

		$local_log =& LoggerManager::getLogger('index');
		$focus = new Activity();
		
		$tab_type = 'Calendar';
		$focus->column_fields["activitytype"] = 'Task';
		$focus->id = "";
		$focus->mode = "";
		
		$focus->column_fields['subject'] = "The Customer Contact Person with the record number {$resultrow['z_cuc_crmno']}";
		$focus->column_fields['assigned_user_id'] = $_SESSION['authenticated_user_id'];
		$focus->column_fields['date_start'] = date('Y-m-d');
		$focus->column_fields['time_start'] = "07:00:00";
		$focus->column_fields['time_end'] = "07:10:00";
		$focus->column_fields['due_date'] = date('Y-m-d');
		$focus->column_fields['parent_id'] = "";
		$focus->column_fields['contact_id'] = "";
		$focus->column_fields['taskstatus'] = "Not Started";
		$focus->column_fields['eventstatus'] = "";
		$focus->column_fields['taskpriority'] = "High";
		$focus->column_fields['sendnotification'] = 0;
		$focus->column_fields['createdtime'] = "";
		$focus->column_fields['modifiedtime'] = "";
		$focus->column_fields['activitytype'] = "Task";
		$focus->column_fields['visibility'] = "Private";
		$focus->column_fields['description'] = "The Customer Contact Person with the record number {$resultrow['z_cuc_crmno']} - {$resultrow['z_cuc_lastname']}, {$resultrow['z_cuc_firstname']} has not been updated for the past 60 days. Should this record be changed, please do so.";
		$focus->column_fields['duration_hours'] = "";
		$focus->column_fields['duration_minutes'] = "";
		$focus->column_fields['location'] = "";
		$focus->column_fields['reminder_time'] = "";
		$focus->column_fields['recurringtype'] = "";
		$focus->column_fields['notime'] = 0;
		$focus->column_fields['modifiedby'] = "";
		
		$focus->save($tab_type);		
	}
}

?>
