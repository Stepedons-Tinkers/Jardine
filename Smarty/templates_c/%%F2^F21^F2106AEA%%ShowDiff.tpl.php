<?php /* Smarty version 2.6.18, created on 2014-06-22 21:23:55
         compiled from modules/ModTracker/ShowDiff.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'modules/ModTracker/ShowDiff.tpl', 35, false),array('modifier', 'getTranslatedString', 'modules/ModTracker/ShowDiff.tpl', 42, false),)), $this); ?>

<div id="orgLay" class="layerPopup">

<!-- Styles for highlighting the string diff -->
<style type='text/css'>
<?php echo '
del { text-decoration: none; display: none; }
ins { text-decoration: none; background-color: #FDFF00; }
'; ?>

</style>

<table class="layerHeadingULine" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td class="layerPopupHeading" align="left" width="70%">
		<?php echo $this->_tpl_vars['TRACKRECORD']->getDisplayName(); ?>


					</td>
	<td align="right" width="2%" valign="top">
		<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" onclick="ModTrackerCommon.hide();" align="right" border="0"></a>
	</td>
</tr>
</table>

<table class="layerHeadingULine" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td><?php echo getTranslatedString('LBL_CHANGED_BY', $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['TRACKRECORD']->getModifiedByLabel(); ?>
 @ <?php echo $this->_tpl_vars['TRACKRECORD']->getModifiedOn(); ?>
</td>

	<td align="right" width="10%">
		<?php if ($this->_tpl_vars['ATPOINT_PREV'] != $this->_tpl_vars['ATPOINT']): ?>
			<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('previous.gif', $this->_tpl_vars['THEME']); ?>
" onclick="ModTrackerCommon.showhistory(<?php echo $this->_tpl_vars['TRACKRECORD']->crmid; ?>
,<?php echo $this->_tpl_vars['ATPOINT_PREV']; ?>
);" border="0"></a>
		<?php else: ?>
			<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('previous_disabled.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></a>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['ATPOINT'] > 0): ?>
			<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('next.gif', $this->_tpl_vars['THEME']); ?>
" onclick="ModTrackerCommon.showhistory(<?php echo $this->_tpl_vars['TRACKRECORD']->crmid; ?>
,<?php echo $this->_tpl_vars['ATPOINT_NEXT']; ?>
);" border="0"></a>
		<?php else: ?>
			<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('next_disabled.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></a>
		<?php endif; ?>
	</td>
</tr>
</table>

<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
<tr>
	<td>
		<table border="0" cellpadding="4" cellspacing="1" width="100%" class='lvt small'>
		<tr valign="top">
			<td width='20%' class='lvtCol'><b><?php echo getTranslatedString('LBL_Field', $this->_tpl_vars['MODULE']); ?>
</b></td>
			<td width='40%' class='lvtCol'><b><?php echo getTranslatedString('LBL_Earlier', $this->_tpl_vars['MODULE']); ?>
</b></td>
			<td width='40%' class='lvtCol'><b><?php echo getTranslatedString('LBL_Present', $this->_tpl_vars['MODULE']); ?>
</b></td>
		</tr>
		<?php $_from = $this->_tpl_vars['TRACKRECORD']->getDetails(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['DETAIL']):
?>
		<tr valign=top>
			<td class='dvtCellLabel'><?php echo $this->_tpl_vars['DETAIL']->getDisplayName(); ?>
</td>
			<td class='lvtColData'><?php echo $this->_tpl_vars['DETAIL']->getDisplayLabelForPreValue(); ?>
</td>
			<td class='lvtColData'><?php if ($_REQUEST['highlight'] == 'true'): ?><?php echo $this->_tpl_vars['DETAIL']->diffHighlight(); ?>
<?php else: ?><?php echo $this->_tpl_vars['DETAIL']->getDisplayLabelForPostValue(); ?>
<?php endif; ?></td>
		</tr>
        <?php endforeach; else: ?>
        <tr>
			<td colspan="3" align="center">
				<?php echo ((is_array($_tmp='LBL_ACCESS_TO_FIELD_CHANGES_DENIED')) ? $this->_run_mod_handler('getTranslatedString', true, $_tmp, $this->_tpl_vars['MODULE']) : getTranslatedString($_tmp, $this->_tpl_vars['MODULE'])); ?>

			</td>
		</tr>
		<?php endif; unset($_from); ?>
		<tr>
			<td class='lvtColData' colspan="3" align="center">
				<input value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmButton small cancel" onclick="ModTrackerCommon.hide();" type="button">
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</div>