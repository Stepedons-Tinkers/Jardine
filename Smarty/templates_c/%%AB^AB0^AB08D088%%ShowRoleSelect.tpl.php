<?php /* Smarty version 2.6.18, created on 2014-06-02 18:48:55
         compiled from modules/PickList/ShowRoleSelect.tpl */ ?>
<b><?php echo $this->_tpl_vars['MOD']['LBL_SELECT_ROLES']; ?>
</b><br>
<select multiple id="roleselect" name="roleselect" class="small crmFormList" style="overflow:auto; height: 80px;width:200px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
	<?php $_from = $this->_tpl_vars['ROLES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['roleid'] => $this->_tpl_vars['rolename']):
?>
		<option value="<?php echo $this->_tpl_vars['roleid']; ?>
"><?php echo $this->_tpl_vars['rolename']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
</select>