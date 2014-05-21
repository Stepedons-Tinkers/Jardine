<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

 $module = Vtiger_Module::getInstance('House');
 $module->unsetRelatedList(Vtiger_Module::getInstance('Payments'), 'Payments', 'get_dependents_list');

?>