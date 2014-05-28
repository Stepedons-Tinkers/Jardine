<?php /* Smarty version 2.6.18, created on 2014-05-23 16:22:05
         compiled from salesEditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtlib_purify', 'salesEditView.tpl', 44, false),array('modifier', 'vtiger_imageurl', 'salesEditView.tpl', 104, false),array('modifier', 'getTranslatedString', 'salesEditView.tpl', 116, false),array('modifier', 'cat', 'salesEditView.tpl', 121, false),array('modifier', 'in_array', 'salesEditView.tpl', 194, false),)), $this); ?>


<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-<?php echo $this->_tpl_vars['CALENDAR_LANG']; ?>
.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/js/FieldDependencies.js"></script>
<script type="text/javascript" src="modules/com_vtiger_workflow/resources/jquery-1.2.6.js"></script>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script type="text/javascript">
	jQuery.noConflict();
</script>
<?php if ($this->_tpl_vars['PICKIST_DEPENDENCY_DATASOURCE'] != ''): ?>
<script type="text/javascript">
	jQuery(document).ready(function() { (new FieldDependencies(<?php echo $this->_tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']; ?>
)).init() });
</script>
<?php endif; ?>

<!-- overriding the pre-defined #company to avoid clash with vtiger_field in the view -->
<?php echo '
<style type=\'text/css\'>
#company {
	height: auto;
	width: 90%;
}
</style>
'; ?>


<script type="text/javascript">
var gVTModule = '<?php echo vtlib_purify($_REQUEST['module']); ?>
';
function sensex_info()
{
        var Ticker = $('tickersymbol').value;
        if(Ticker!='')
        {
                $("vtbusy_info").style.display="inline";
                new Ajax.Request(
                      'index.php',
                      {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Tickerdetail&tickersymbol='+Ticker,
                                onComplete: function(response) {
                                        $('autocom').innerHTML = response.responseText;
                                        $('autocom').style.display="block";
                                        $("vtbusy_info").style.display="none";
                                }
                        }
                );
        }
}
function AddressSync(Addform,id)
{
	checkAddress(Addform,id);
}

</script>

<!--ed edited-->
<?php echo '
<script type="text/javascript">
if (typeof jQuery != \'undefined\') {
    jQuery(document).ready(function(){
        //saving change
        jQuery.fn.saveFLow = function(){ 
            return this.each(function () {
                var B = jQuery(this);
                if(jQuery("[id=\'saveFlow2\']")){
                    B.css("display","");
                }
				B.unbind().click(function(e){		//this was once incorporated with the save element
					this.form.action.value=\'Save\'; 
					displaydeleted(); 
					return formValidate();
				});
            });
        }
        jQuery("[id=\'saveFlow\']").saveFLow();
    });
} 
</script>
'; ?>

<!--ed edited end-->

		<br>
		<br>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

	<td class="showPanelBg" valign=top width=100%>
				<div class="small" style="padding:20px">
						<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
			<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
				
			<?php if ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?> 
				<?php $this->assign('USE_ID_VALUE', $this->_tpl_vars['MOD_SEQ_ID']); ?>
		  		<?php if ($this->_tpl_vars['USE_ID_VALUE'] == ''): ?> <?php $this->assign('USE_ID_VALUE', $this->_tpl_vars['ID']); ?> <?php endif; ?>			
				<span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['USE_ID_VALUE']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 - <?php echo $this->_tpl_vars['APP']['LBL_EDITING']; ?>
 <?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span> <br>
				<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
			<?php endif; ?>
			<?php if ($this->_tpl_vars['OP_MODE'] == 'create_view'): ?>
				<?php if ($this->_tpl_vars['DUPLICATE'] != 'true'): ?>
		            <?php $this->assign('create_new', ((is_array($_tmp='LBL_CREATING_NEW_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['SINGLE_MOD']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['SINGLE_MOD']))); ?>
										<?php $this->assign('create_newlabel', $this->_tpl_vars['APP'][$this->_tpl_vars['create_new']]); ?>
					<?php if ($this->_tpl_vars['create_newlabel'] != ''): ?>
						<span class="lvtHeaderText"><?php echo $this->_tpl_vars['create_newlabel']; ?>
</span> <br>
					<?php else: ?>
						<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_CREATING']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_NEW']; ?>
 <?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
</span> <br>
					<?php endif; ?>
				<?php else: ?>
					<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATING']; ?>
 "<?php echo $this->_tpl_vars['NAME']; ?>
" </span> <br>
				<?php endif; ?>
			<?php endif; ?>

			<hr noshade size=1>
			<br> 
		
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

						<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			   <tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
					   <tr>
						<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						<td class="dvtSelectedCell" align=center nowrap> <?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
						<td class="dvtTabCache" style="width:10px">&nbsp;</td>
						<td class="dvtTabCache" style="width:100%">&nbsp;</td>
					   </tr>
					</table>
				</td>
			   </tr>
			   <tr>
				<td valign=top align=left >
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
					   <tr>

						<td align=left>
												
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding:10px">
									<!-- General details -->
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
												<?php if ($this->_tpl_vars['MODULE'] == 'Webmails'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='<?php echo $this->_tpl_vars['ID']; ?>
'" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
                                                <?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
													<?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>
														<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  if(formValidate()) { if(AjaxDuplicateValidate('Accounts','accountname',this.form)) { AddressSync(this.form,<?php echo $this->_tpl_vars['ID']; ?>
); } }"  type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >

													<?php else: ?>
                                                        <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >

                                                    <?php endif; ?>
												<?php else: ?>
													<input id = "saveFlow" title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px;display:none" >
												<?php endif; ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table> 
									   <!-- included to handle the edit fields based on ui types -->
									   <?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>

																						<?php if (is_array ( $this->_tpl_vars['hideBlocksTPL'] ) && ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['hideBlocksTPL']) : in_array($_tmp, $this->_tpl_vars['hideBlocksTPL']))): ?>
												<?php $this->assign('hidingStatBlock', "style='display:none'"); ?>
											<?php else: ?>
												<?php $this->assign('hidingStatBlock', ""); ?>
											<?php endif; ?>
																					<table border=0 cellspacing=0 cellpadding=0 width=100% id="<?php echo $this->_tpl_vars['header']; ?>
" <?php echo $this->_tpl_vars['hidingStatBlock']; ?>
>
										
							<!-- This is added to display the existing comments -->
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENTS'] || $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']): ?>
							   <tr><td>&nbsp;</td></tr>
							   <tr>
								<td colspan=4 class="dvInnerHeader">
							        	<b><?php echo $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']; ?>
</b>
								</td>
							   </tr>
							   <tr>
								<td colspan=4 class="dvtCellInfo"><?php echo $this->_tpl_vars['COMMENT_BLOCK']; ?>
</td>
							   </tr>
							   <tr><td>&nbsp;</td></tr>
							<?php endif; ?>



									      <tr>
										<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_ADDRESS_INFORMATION'] && ( $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Quotes' || $this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Invoice' )): ?>
                                                                                <td colspan=2 class="detailedViewHeader">
                                                                                <b><?php echo $this->_tpl_vars['header']; ?>
</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_RCPY_ADDRESS']; ?>
</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_LCPY_ADDRESS']; ?>
</b></td>
										<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_ADDRESS_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Contacts'): ?>
										<td colspan=2 class="detailedViewHeader">
                                                                                <b><?php echo $this->_tpl_vars['header']; ?>
</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_CPY_OTHER_ADDRESS']; ?>
</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_CPY_MAILING_ADDRESS']; ?>
</b></td>
                                                                                <?php else: ?>
										<td colspan=4 class="detailedViewHeader">
											<b><?php echo $this->_tpl_vars['header']; ?>
</b>
										<?php endif; ?>
										</td>
									      </tr>

										<!-- Handle the ui types display -->
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

										 <?php if ($this->_tpl_vars['header'] == 'General Information' && $this->_tpl_vars['MODULE'] == 'House'): ?>
										 <tr>
											<td class="dvtCellInfo" colspan=4>
											</td>
										 </tr>
										 <tr>
											 <td class="dvtCellLabel" colspan=1>
												<b>LOCATE MAP</b>
											 </td>
											 <td class="dvtCellInfo" colspan=3>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'GoogleMap.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											 </td>
										 </tr>
										 <tr style="height:25px"><td>&nbsp;</td></tr>
									   <?php endif; ?>
									   </table>
									   <?php endforeach; endif; unset($_from); ?>


									   <!-- Added to display the Product Details in Inventory-->
									   <?php if ($this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Quotes' || $this->_tpl_vars['MODULE'] == 'Invoice'): ?>
							   		   <tr>
										<td colspan=4>
											<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ProductDetailsEditView.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
										</td>
							   		   </tr>
									   <?php endif; ?>

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
										<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
										<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Webmails'): ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='<?php echo $this->_tpl_vars['ID']; ?>
'" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>
												<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  if(formValidate()) { if(AjaxDuplicateValidate('Accounts','accountname',this.form)) { AddressSync(this.form,'<?php echo $this->_tpl_vars['ID']; ?>
'); } }"  type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											<?php else: ?>
												<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											<?php endif; ?>
										<?php else: ?>
											<input id = "saveFlow" title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px;display:none" >
										<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table>
								</td>
							   </tr>
							</table>
						</td>
					   </tr>
					</table>
				</td>
			   </tr>
			</table>
		<div>
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
<!--added to fix 4600-->
<input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH']; ?>
'>
</form>


<?php if (( $this->_tpl_vars['MODULE'] == 'Emails' || 'Documents' ) && ( $this->_tpl_vars['USE_RTE'] == 'true' )): ?>
	<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
<script type="text/javascript" defer="1">
	var textAreaName = null;
	<?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
		textAreaName = "notecontent";
	<?php else: ?>
		textAreaName = 'description';
	<?php endif; ?>

	<!-- Solution for ticket #6756-->
	CKEDITOR.replace( textAreaName,
	{
		extraPlugins : 'uicolor',
		uiColor: '#dfdff1',
			on : {
				instanceReady : function( ev ) {
					 this.dataProcessor.writer.setRules( 'p',  {
						indent : false,
						breakBeforeOpen : false,
						breakAfterOpen : false,
						breakBeforeClose : false,
						breakAfterClose : false
				});
			}
		}
	});
	var oCKeditor = CKEDITOR.instances[textAreaName];
</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
<?php endif; ?>
<script>	

        var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
)

        var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
)

        var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
)

	var ProductImages=new Array();
	var count=0;

	function delRowEmt(imagename)
	{
		ProductImages[count++]=imagename;
	}

	function displaydeleted()
	{
		var imagelists='';
		for(var x = 0; x < ProductImages.length; x++)
		{
			imagelists+=ProductImages[x]+'###';
		}

		if(imagelists != '')
			document.EditView.imagelist.value=imagelists
	}

</script>

<!-- vtlib customization: Help information assocaited with the fields -->
<?php if ($this->_tpl_vars['FIELDHELPINFO']): ?>
<script type='text/javascript'>
<?php echo 'var fieldhelpinfo = {}; '; ?>

<?php $_from = $this->_tpl_vars['FIELDHELPINFO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FIELDHELPKEY'] => $this->_tpl_vars['FIELDHELPVAL']):
?>
	fieldhelpinfo["<?php echo $this->_tpl_vars['FIELDHELPKEY']; ?>
"] = "<?php echo $this->_tpl_vars['FIELDHELPVAL']; ?>
";
<?php endforeach; endif; unset($_from); ?>
</script>
<?php endif; ?>
<!-- END -->