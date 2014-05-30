<?php /* Smarty version 2.6.18, created on 2014-05-30 21:44:36
         compiled from LoginHeader.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['LBL_CHARSET']; ?>
">
<title>CRM</title>
<style type="text/css">@import url("include/style.css");</style>
<script language="JavaScript" type="text/javascript" src="include/js/popup.js"></script>
<script type="text/javascript" language="JavaScript">
function set_focus() {
	if (document.DetailView.user_name.value != '') {
		document.DetailView.user_password.focus();
		document.DetailView.user_password.select();
	}
	else document.DetailView.user_name.focus();
}
</script>

<script type="text/javascript">
//<![CDATA[
function cu(t, n)
{
  if ( n == 1 )
  {
    if ( t.value == '' )
    {
      t.value = 'username';
    }
  }
  else if ( n == 0 )
  {
    var u = 'username';
        
    if ( t.value == u )
    {
        t.value = '';
    }
  }
}
function cp(t, n)
{
  if ( n == 1 )
  {
    if ( t.value == '' )
    {
      t.value = 'password';
    }
  }
  else if ( n == 0 )
  {
    if ( t.value == 'password' )
    {
        t.value = '';
    }
  }
}
//]]>
</script>
	
</head>
<body onload="set_focus()">
	<div class="loginContainer"> 