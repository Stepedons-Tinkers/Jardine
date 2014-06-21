<?php /* Smarty version 2.6.18, created on 2014-06-21 18:21:25
         compiled from modules/PickList/DeletePickList.tpl */ ?>
<div style="position:relative;display: block;" class="layerPopup">
	<table border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
		<tr>
			<td class="layerPopupHeading" align="left" nowrap>
				<?php echo $this->_tpl_vars['MOD']['DELETE_PICKLIST_VALUES']; ?>
 - <?php echo $this->_tpl_vars['FIELDLABEL']; ?>

			</td>
		</tr>
	</table>

	<table border=0 cellspacing=0 cellpadding=5 >
		<tr><td valign=top align=left>
				<select id="delete_availPickList" multiple="multiple" wrap size="20" name="availList" style="width:250px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
					<?php $_from = $this->_tpl_vars['PICKVAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pick_key'] => $this->_tpl_vars['pick_val']):
?>
						<option value="<?php echo $this->_tpl_vars['pick_key']; ?>
"><?php echo $this->_tpl_vars['pick_val']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td nowrap>
				<b><?php echo $this->_tpl_vars['MOD']['LBL_REPLACE_WITH']; ?>
</b>&nbsp;
				<select id="replace_picklistval" name="replaceList" style="border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
					<option value=""></option>
					<?php $_from = $this->_tpl_vars['PICKVAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pick_key'] => $this->_tpl_vars['pick_val']):
?>
						<option value="<?php echo $this->_tpl_vars['pick_key']; ?>
"><?php echo $this->_tpl_vars['pick_val']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
					<?php $_from = $this->_tpl_vars['NONEDITPICKLIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nonedit']):
?>
						<option value="<?php echo $this->_tpl_vars['nonedit']; ?>
"><?php echo $this->_tpl_vars['nonedit']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign=top align=left>
				<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
" name="del" class="crmButton small delete" onclick="validateDelete('<?php echo $this->_tpl_vars['FIELDNAME']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
');">
				<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" name="cancel" class="crmButton small cancel" onclick="fnhide('actiondiv');">
			</td>			
		</tr>
	
		<?php if (is_array ( $this->_tpl_vars['NONEDITPICKLIST'] )): ?>
		<tr>
			<td colspan=3>
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
					<tr><td><b><?php echo $this->_tpl_vars['MOD']['LBL_NON_EDITABLE_PICKLIST_ENTRIES']; ?>
 :</b></td></tr>
					<tr><td>
					<select id="nonEditablePicklistVal" name="nonEditablePicklistVal" multiple="multiple" wrap size="5" style="width: 100%">
					<?php $_from = $this->_tpl_vars['NONEDITPICKLIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nonedit']):
?>
						<option value="<?php echo $this->_tpl_vars['nonedit']; ?>
" disabled><?php echo $this->_tpl_vars['nonedit']; ?>
</option>							
					<?php endforeach; endif; unset($_from); ?>
					</select>
				</table>
			</td>
		</tr>	
		<?php endif; ?>
	</table>
</div>