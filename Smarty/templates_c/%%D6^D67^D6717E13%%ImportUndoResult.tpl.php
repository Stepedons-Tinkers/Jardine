<?php /* Smarty version 2.6.18, created on 2014-06-08 16:34:51
         compiled from modules/Import/ImportUndoResult.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/Import/ImportUndoResult.tpl', 22, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/MailManager/resources/jquery-1.6.2.min.js"></script>
<script type="text/javascript" charset="utf-8">
	jQuery.noConflict();
</script>
<script language="JavaScript" type="text/javascript" src="modules/Import/resources/Import.js"></script>

<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['FOR_MODULE']; ?>
" />
<table style="width:70%;margin-left:auto;margin-right:auto;margin-top:10px;" cellpadding="10" cellspacing="10" class="searchUIBasic">
	<tr>
		<td class="heading2" align="left" colspan="2">
			<?php echo getTranslatedString('LBL_IMPORT', $this->_tpl_vars['MODULE']); ?>
 <?php echo getTranslatedString($this->_tpl_vars['FOR_MODULE'], $this->_tpl_vars['FOR_MODULE']); ?>
 - <?php echo getTranslatedString('LBL_UNDO_RESULT', $this->_tpl_vars['MODULE']); ?>

		</td>
	</tr>
	<?php if ($this->_tpl_vars['ERROR_MESSAGE'] != ''): ?>
	<tr>
		<td class="style1" align="left" colspan="2">
			<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>

		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td colspan="2" valign="top">
			<table cellpadding="10" cellspacing="0" align="center" class="dvtSelectedCell thickBorder">
				<tr>
					<td><?php echo getTranslatedString('LBL_TOTAL_RECORDS', $this->_tpl_vars['MODULE']); ?>
</td>
					<td width="10%">:</td>
					<td width="10%"><?php echo $this->_tpl_vars['TOTAL_RECORDS']; ?>
</td>
				</tr>
				<tr>
					<td><?php echo getTranslatedString('LBL_NUMBER_OF_RECORDS_DELETED', $this->_tpl_vars['MODULE']); ?>
</td>
					<td width="10%">:</td>
					<td width="10%"><?php echo $this->_tpl_vars['DELETED_RECORDS_COUNT']; ?>
</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'modules/Import/Import_Done_Buttons.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
</table>