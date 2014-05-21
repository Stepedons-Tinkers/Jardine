<?php
    // Turn on debugging level
    $Vtiger_Utils_Log = true;

    include_once('vtlib/Vtiger/Menu.php');
    include_once('vtlib/Vtiger/Module.php');
    
    // Create module instance and save it first
    $module = new Vtiger_Module();
    $module->name = 'ModCreator';
    $module->save();
    $module->initWebservice();
    
    // Initialize all the tables required
    $module->initTables();
    
    // Add the module to the Menu (entry point from UI)
    $menu = Vtiger_Menu::getInstance('Tools');
    $menu->addModule($module);
   
?>