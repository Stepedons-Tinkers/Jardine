{if $AJAX eq 'true'}
&#&#&#{$ERROR}&#&#&#
{/if}
<table align="center" border="0" cellpadding="4px" cellspacing="0" width="100%">
	<tr>
		<td class="dvInnerHeader" colspan=4>
			<span class="dvHeaderText">&nbsp;&nbsp;Home Owner Details</span>
		</td>
	</tr>
	<tr>
		<td width="25%" class="dvtCellLabel" align="right">
			Home Owner Name
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=homeowner value=$DATA.homeowner}
			{$homeowner}
		</td>
		<td width="25%" class="dvtCellLabel" align="right">
			Status
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=status value=$DATA.status}
			{$status}
		</td>
	</tr>
	<tr>
		<td width="25%" class="dvtCellLabel" align="right">
			Unpaid Bills
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=pendingBills value=$DATA.pendingBills}
			{$pendingBills}
		</td>
		<td width="25%" class="dvtCellLabel" align="right">
			Amount
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=pendingAmount value=$DATA.pendingAmount}
			{$pendingAmount}
		</td>
	</tr>
	<tr>
		<td width="25%" class="dvtCellLabel" align="right">
			Unpaid Memo
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=pendingmemo value=$DATA.pendingmemo}
			{$pendingmemo}
		</td>
		<td width="25%" class="dvtCellLabel" align="right">
			Amount
		</td>
		<td width="25%" class="dvtCellInfo" align="left">
			{assign var=pendingAmountmemo value=$DATA.pendingAmountmemo}
			{$pendingAmountmemo}
		</td>
	</tr>
	
	<tr>
		<td colspan=4 class="dvtCellInfo" align="center">
			{if $status eq 'ACTIVE'}
				<span class="dvHeaderText" style="font-size:50px;color:green;">Pass</span>
			{elseif $status eq 'PENDING'}
				<span class="dvHeaderText" style="font-size:50px;color:red;">Do not pass</span>
			{elseif $ERROR eq 'Non existing Car'}
				<span class="dvHeaderText" style="font-size:50px;color:black;">Non existing car</span>
			{else}
			{/if}
		</td>
	</tr>
	
</table>
{if $AJAX eq 'true'}
&#&#&#
{/if}
