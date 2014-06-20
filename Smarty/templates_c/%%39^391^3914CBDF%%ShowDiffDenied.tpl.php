<?php /* Smarty version 2.6.18, created on 2014-06-18 19:42:44
         compiled from modules/ModTracker/ShowDiffDenied.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/ModTracker/ShowDiffDenied.tpl', 15, false),array('modifier', 'vtiger_imageurl', 'modules/ModTracker/ShowDiffDenied.tpl', 18, false),)), $this); ?>
 
<div id="orgLay" class="layerPopup">

<table class="layerHeadingULine" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td class="layerPopupHeading" align="left" nowrap="nowrap" width="70%">
		<?php echo getTranslatedString('LBL_ACCESS_RESTRICTED', $this->_tpl_vars['MODULE']); ?>

	</td>
	<td align="right" width="2%">
		<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" onclick="ModTrackerCommon.hide();" align="right" border="0"></a>
	</td>
</tr>
</table>

<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
<tr>
	<td>
		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tr class='lvtColData'>
			<td rowspan='2' width='11%'><img src="<?php echo vtiger_imageurl('denied.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
				<span class='genHeaderSmall'><?php echo getTranslatedString('LBL_NOT_PERMITTED_TO_ACCESS_INFORMATION', $this->_tpl_vars['MODULE']); ?>
</span>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>		
</div>