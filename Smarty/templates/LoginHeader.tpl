{*<!--
/*+********************************************************************************
  * The contents of this file are subject to the vtiger CRM Public License Version 1.0
  * ("License"); You may not use this file except in compliance with the License
  * The Original Code is:  vtiger CRM Open Source
  * The Initial Developer of the Original Code is vtiger.
  * Portions created by vtiger are Copyright (C) vtiger.
  * All Rights Reserved.
  *********************************************************************************/
-->*}
<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$LBL_CHARSET}">
<title>CRM</title>
<style type="text/css">@import url("include/style.css");</style>
<script language="JavaScript" type="text/javascript" src="include/js/popup.js"></script>
<script type="text/javascript" language="JavaScript">
function set_focus() {ldelim}
	if (document.DetailView.user_name.value != '') {ldelim}
		document.DetailView.user_password.focus();
		document.DetailView.user_password.select();
	{rdelim}
	else document.DetailView.user_name.focus();
{rdelim}
</script>

<script type="text/javascript">
//<![CDATA[
function cu(t, n)
{ldelim}
  if ( n == 1 )
  {ldelim}
    if ( t.value == '' )
    {ldelim}
      t.value = 'username';
    {rdelim}
  {rdelim}
  else if ( n == 0 )
  {ldelim}
    var u = 'username';
        
    if ( t.value == u )
    {ldelim}
        t.value = '';
    {rdelim}
  {rdelim}
{rdelim}
function cp(t, n)
{ldelim}
  if ( n == 1 )
  {ldelim}
    if ( t.value == '' )
    {ldelim}
      t.value = 'password';
    {rdelim}
  {rdelim}
  else if ( n == 0 )
  {ldelim}
    if ( t.value == 'password' )
    {ldelim}
        t.value = '';
    {rdelim}
  {rdelim}
{rdelim}
//]]>
</script>
	
</head>
<body onload="set_focus()">
	<div class="loginContainer"> 