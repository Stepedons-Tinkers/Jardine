<?php
	include_once "modules/{$_REQUEST[functionNextIX]}/Ajax.php";
	
	$ajax = new Ajax();
	$ajax->setRequests($_REQUEST);
	$ajax->setHeader();
	$ajax->queryData();
	
	if(isset($_REQUEST['exportToExcel']) && $_REQUEST['exportToExcel'] == 'yes'){
		header("Content-Disposition: attachment; filename=".$fileName."{$_REQUEST[functionNextIX]}.xls");
		header("Content-type: application/vnd.ms-excel");
		$ajax->setDisplayExcel();
	}
	else
		$ajax->setDisplay();
?>