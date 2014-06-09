<?php
error_reporting(0);
//manipulated modules/Users/Authenticate.php			// Error in IP address for storing in LoginHistory


if(php_sapi_name() == 'cli'){			//from CRON

	$_REQUEST['module'] = 'Users';
	$_REQUEST['action'] = 'Authenticate';
	$_REQUEST['return_module'] = 'Users';
	$_REQUEST['return_action'] = 'Login';
	$_REQUEST['user_name'] = 'nextixadmin';
	$_REQUEST['user_password'] = '1212';		
	include_once "index.php";
	include_once "index_cron.php";
	
	include_once "include/nextixlib/Cron.php";
	// include_once "include/nextixlib/DBConnect.php";
	
	$cron = new Cron();
	$cron->ccperson_daysUnchanged();
	// $cron->updateMembersAge();
	// $cron->updateMembershipCardIfExpired();
	
	
	
	session_destroy();
	echo "CRON EXECUTION COMPLETE!!";
}

?>
