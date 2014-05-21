<?php
global $currentModule;

require_once 'modules/'.$currentModule.'/config/configuration.php';
require_once $configuration['path'].'/data/ControllerCore.php';


if(!isset($_REQUEST['controller'])){
	require_once $configuration['path']."controller/".$configuration['default_controller'].".php";
	$obj = new $configuration['default_controller']();
	$obj->setTemplatePath($configuration['path']."templates/");
	}
else{
	require_once $configuration['path']."controller/".$_REQUEST['controller'].".php";
	$obj = new $_REQUEST['controller']();
	$obj->setTemplatePath($configuration['path']."templates/");
	}
	

$obj->dirPath($configuration['path']);	
$obj->dirPathAbsolute($root_directory);
$obj->__initialize();


if(!isset($_REQUEST['controller_action'])){
		$obj->$configuration['default_controller_action']();
	}
else{
		if(method_exists($_REQUEST['controller'],$_REQUEST['controller_action'])){
			$obj->$_REQUEST['controller_action']();
		}
		else{
			echo "ERROR";
		}	
	}


?>