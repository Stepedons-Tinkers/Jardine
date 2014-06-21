<?php /* Smarty version 2.6.18, created on 2014-06-21 15:24:23
         compiled from viewBox.tpl */ ?>
<script>
function callSearch(searchtype,hview,module,searchfield)
{
		var homeOwner = jQuery("[name='record']").val();

		search_fld_val= $(searchfield).options[$(searchfield).selectedIndex].value;
		
		if(module == 'Billing')
			search_txt_val= encodeURIComponent(document.basicSearch.search_text.value);
		else if(module == 'MemoAdvice')
			search_txt_val= encodeURIComponent(document.basicSearch2.search_text.value);
		

        var urlstring = '';
        if(searchtype == 'Basic')
        {
        		var p_tab = document.getElementsByName("parenttab");
                urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
                urlstring = urlstring + 'parenttab='+p_tab[0].value+ '&';
        }
       
		$("status").style.display="inline";
		new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody:urlstring +'query=true&file=index&module='+module+'&action='+module+'Ajax&ajax=true&search=true&hmode=viewBox&hview='+hview+'&homeowner='+homeOwner,
				onComplete: function(response) {
									result = response.responseText.split('&#&#&#');
									$(hview).innerHTML= result[2];
				}
			   }
			);
		return false
}
</script>

<div id="viewBox" class="layerPopup" style="display:none;
			padding:0px;
			position:absolute;
			top:240px;
			left:7%;
			background-color:white;
			width:80%;
			min-width:650px;
			"><span style="z-index:100;
										display:block;
										float:left;
										padding:5px 0 0 12px;"><b>[ Billing ]</b></span>
						<a id="close" href="javascript:void(0)" style="z-index:100;
														display:block;
														float:right;
														padding:5px 12px 0 0;
														">x</a>
						<a id="refresh" href="javascript:void(0)" style="z-index:100;
														display:block;
														float:right;
														padding:5px 12px 0 0;
														">Refresh</a>
				<br>
				<br>
				<br>
				<br>
				<div id="searchAcc" style="display: block;padding-left:18px">
					<form name="basicSearch" method="post" action="index.php" onSubmit="return callSearch('Basic');">
						<table width="90%" cellpadding="5" cellspacing="0"  class="searchUIBasic small" align="center" border=0>
							<tr>
								<td class="small" nowrap align=right><b><?php echo $this->_tpl_vars['APP']['LBL_SEARCH_FOR']; ?>
</b></td>
								<td class="small"><input type="text"  class="txtBox" style="width:120px" name="search_text"></td>
								<td class="small" nowrap><b><?php echo $this->_tpl_vars['APP']['LBL_IN']; ?>
</b>&nbsp;</td>
								<td class="small" nowrap>
								
									<div id="basicsearchcolumns_real">
									<select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">
										<option label="Bill No." value="billno">Bill No.</option>
										<option label="Homeowner" value="homeowner">Homeowner</option>
										<option label="Amount" value="amount">Amount</option>
										<option label="Purpose" value="purpose">Purpose</option>
										<option label="Status" value="b_status">Status</option>
										<option label="Date of Bill" value="date_of_bill">Date of Bill</option>
										<option label="Created Time" value="CreatedTime">Created Time</option>
										<option label="Modified Time" value="ModifiedTime">Modified Time</option>
										<option label="Assigned To" value="assigned_user_id">Assigned To</option>
									</select>
									</div>
									
											<input type="hidden" name="searchtype" value="BasicSearch">
											<input type="hidden" name="module" value="B" id="curmodule">
											<input name="maxrecords" type="hidden" value="5" id='maxrecords'>
											<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
											<input type="hidden" name="action" value="index">
											<input type="hidden" name="query" value="true">
											<input type="hidden" name="search_cnt">
								</td>
								<td class="small" nowrap width=40% >
									  <input name="submit" type="button" class="crmbutton small create" onClick="callSearch('Basic','viewBoxContainer','Billing','bas_searchfield');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 ">&nbsp;  
								</td>
							</tr>
						</table>
					</form>
				</div>
				
				<div id="viewBoxContainer" style="height:90%;width:90%;margin:20px auto;">
				</div>		
				
			</div>
<div id="viewBox2" class="layerPopup" style="display:none;
			position:absolute;
			top:240px;
			left:7%;
			background-color:white;
			width:80%;
			min-width:650px;
	"><span style="z-index:100;
										display:block;
										float:left;
										padding:5px 0 0 12px;"><b>[ Memo Advice ]</b></span>
						<a id="close2" href="javascript:void(0)" style="z-index:100;
														display:block;
														float:right;
														padding:5px 12px 0 0;
														">x</a>
						<a id="refresh2" href="javascript:void(0)" style="z-index:100;
														display:block;
														float:right;
														padding:5px 12px 0 0;
														">Refresh</a>
			<br>
			<br>
			<br>
			<br>
				<div id="searchAcc" style="display: block;padding-left:18px">
					<form name="basicSearch2" method="post" action="index.php" onSubmit="return callSearch('Basic');">
						<table width="90%" cellpadding="5" cellspacing="0"  class="searchUIBasic small" align="center" border=0>
							<tr>
								<td class="small" nowrap align=right><b><?php echo $this->_tpl_vars['APP']['LBL_SEARCH_FOR']; ?>
</b></td>
								<td class="small"><input type="text"  class="txtBox" style="width:120px" name="search_text"></td>
								<td class="small" nowrap><b><?php echo $this->_tpl_vars['APP']['LBL_IN']; ?>
</b>&nbsp;</td>
								<td class="small" nowrap>
								
									<div id="basicsearchcolumns_real">
									<select name="search_field" id="bas_searchfield2" class="txtBox" style="width:150px">
										<option label="Memo Advice No." value="memo_no">Memo Advice No.</option>
										<option label="Homeowner No." value="homeowner">Homeowner No.</option>
										<option label="Purpose" value="ma_purpose">Purpose</option>
										<option label="Amount" value="amount">Amount</option>
										<option label="Amount Paid" value="amount_paid">Amount Paid</option>
										<option label="Status" value="ma_status">Status</option>
										<option label="Date of Memo" value="date_of_memo">Date of Memo</option>
										<option label="Created Time" value="CreatedTime">Created Time</option>
										<option label="Assigned To" value="assigned_user_id">Assigned To</option>
									</select>
									</div>
									
											<input type="hidden" name="searchtype" value="BasicSearch">
											<input type="hidden" name="module" value="B" id="curmodule">
											<input name="maxrecords" type="hidden" value="5" id='maxrecords'>
											<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
											<input type="hidden" name="action" value="index">
											<input type="hidden" name="query" value="true">
											<input type="hidden" name="search_cnt">
								</td>
								<td class="small" nowrap width=40% >
									  <input name="submit" type="button" class="crmbutton small create" onClick="callSearch('Basic','viewBoxContainer2','MemoAdvice','bas_searchfield2');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 ">&nbsp;  
								</td>
							</tr>
						</table>
					</form>
				</div>
			<div id="viewBoxContainer2" style="height:90%;width:90%;margin:20px auto;"></div>											
			</div>