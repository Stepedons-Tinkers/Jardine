<?php /* Smarty version 2.6.18, created on 2014-05-28 11:36:21
         compiled from DisplayFields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'in_array', 'DisplayFields.tpl', 27, false),)), $this); ?>

<?php $this->assign('fromlink', ""); ?>

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['subdata']):
?>
	<?php if ($this->_tpl_vars['header'] == 'Product Details'): ?>
		<tr>
	<?php else: ?>
		<tr style="height:25px">
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
								<?php if (is_array ( $this->_tpl_vars['hideFieldsTPL'] ) && ((is_array($_tmp=$this->_tpl_vars['maindata'][2][0])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['hideFieldsTPL']) : in_array($_tmp, $this->_tpl_vars['hideFieldsTPL']))): ?>
				<?php $this->assign('hidingStatField', "style='display:none'"); ?>
			<?php else: ?>
				<?php $this->assign('hidingStatField', ""); ?>
			<?php endif; ?>
						<?php if (is_array ( $this->_tpl_vars['forcedisable'] ) && ((is_array($_tmp=$this->_tpl_vars['maindata'][2][0])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['forcedisable']) : in_array($_tmp, $this->_tpl_vars['forcedisable']))): ?>
				<?php $this->assign('forcedisableStat', 'disabled'); ?>
				<?php $this->assign('hidingIMG', "style='display:none'"); ?>
			<?php else: ?>
				<?php $this->assign('forcedisableStat', ""); ?>
				<?php $this->assign('hidingIMG', ""); ?>
			<?php endif; ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endforeach; endif; unset($_from); ?>
   </tr>
<?php endforeach; endif; unset($_from); ?>