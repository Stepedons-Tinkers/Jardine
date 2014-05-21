<br>
<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
	<tr>
		<td colspan=5 class="dvInnerHeader"><div><b>&nbsp;Payment Track</b></div>
	</tr>
</table>
<div style="width:auto;display:block;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
			<tr style="height:25px">
				<td class="dvtCellLabel" align=right width=25%>Payment No.</td>
				<td class="dvtCellLabel" align=right width=25%>Amount Paid</td>
				<td class="dvtCellLabel" align=right width=25%>Date of Payment</td>
				<td class="dvtCellLabel" align=right width=25%>Beginning Balance</td>
				<td class="dvtCellLabel" align=right width=25%>Ending Balance</td>
			</tr>
			
		{foreach key=paymentid item=data from=$PAYMENT_RECORDS}
			{assign var=payment_no value=$data.payment_no}
			{assign var=amount_paid value=$data.amount_paid}
			{assign var=date_of_payment value=$data.date_of_payment}
			{assign var=beginning_balance value=$data.beginning_balance}
			{assign var=ending_balance value=$data.ending_balance}
			<tr style="height:25px">
				<td class="dvtCellInfo" align=right width=25%><a href="index.php?action=DetailView&module=Payments&record={$paymentid}&parenttab=Analytics">{$payment_no}</a></td>
				<td class="dvtCellInfo" align=right width=25%>{$amount_paid}</td>
				<td class="dvtCellInfo" align=right width=25%>{$date_of_payment}</td>
				<td class="dvtCellInfo" align=right width=25%>{$beginning_balance}</td>
				<td class="dvtCellInfo" align=right width=25%>{$ending_balance}</td>
			</tr>
		{/foreach}
	</table>
</div>
<br>