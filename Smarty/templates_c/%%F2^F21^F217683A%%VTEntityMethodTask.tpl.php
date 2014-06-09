<?php /* Smarty version 2.6.18, created on 2014-06-09 11:40:57
         compiled from com_vtiger_workflow/taskforms/VTEntityMethodTask.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'com_vtiger_workflow/taskforms/VTEntityMethodTask.tpl', 59, false),)), $this); ?>

<script type="text/javascript" charset="utf-8">
var moduleName = '<?php echo $this->_tpl_vars['entityName']; ?>
';
var methodName = '<?php echo $this->_tpl_vars['task']->methodName; ?>
';
<?php echo '
	function entityMethodScript($){
		
		function jsonget(operation, params, callback){
			var obj = {
					module:\'com_vtiger_workflow\', 
					action:\'com_vtiger_workflowAjax\',	
					file:operation, ajax:\'true\'};
			$.each(params,function(key, value){
				obj[key] = value;
			});
			$.get(\'index.php\', obj, 
				function(result){
					var parsed = JSON.parse(result);
					callback(parsed);
			});
		}
		
		
		$(document).ready(function(){
			jsonget(\'entitymethodjson\', {module_name:moduleName}, function(result){
				$(\'#method_name_select_busyicon\').hide();
				if(result.length==0){
					$(\'#method_name_select\').hide();
					$(\'#message_text\').show();
				}else{					
					$(\'#method_name_select\').show();
					$(\'#message_text\').hide();
					$.each(result, function(i, v){
						var optionText = \'<option value="\'+v+\'" \'+(v==methodName?\'selected\':\'\')+\'>\'+v+\'</option>\';
						$(\'#method_name_select\').append(optionText);
					});
				}
			});
		});
	}
'; ?>

entityMethodScript(jQuery);
</script>

<table border="0" cellpadding="5" cellspacing="0" width="100%" class="small">
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><b>Method Name: </b></td>
		<td class='dvtCellInfo'>
			<span id="method_name_select_busyicon"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
			<select name="methodName" id="method_name_select" class="small" style="display: none;"></select>
			<span id="message_text" style="display: none;">No method is available for this module.</sspan>
		</td>
	</tr>
</table> 