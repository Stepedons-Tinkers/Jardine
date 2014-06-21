	<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
		<tr>{strip}
		<td colspan=4 class="dvtCellLabel">

			<div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus('tblhouse','aidhouse','{$IMAGE_PATH}');">
						{if $BLOCKINITIALSTATUS[$header] eq 1}
							<img id="aidhouse" src="{'activate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>
						{else}
							<img id="aidhouse" src="{'inactivate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Display" title="Display"/>
						{/if}
					</a></div><b>&nbsp;
					Other Address
				</b></div>
		</td>{/strip}
		</tr>
	</table>

	{if $BLOCKINITIALSTATUS[$header] eq 1}
	<div style="width:auto;display:block;" id="tblhouse" >
	{else}
	<div style="width:auto;display:none;" id="tblhouse" >
	{/if}
	
		<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
			<tr>
				<td class="dvtCellLabel">Unit</td>
				<td class="dvtCellLabel">House No.</td>
				<td class="dvtCellLabel">Street</td>
				<td class="dvtCellLabel">Area</td>
			</tr>
			{foreach item=housedata key=houserecord from=$HOUSES}
				<tr>
						{assign var=house_no value=$housedata.house_no}
						{assign var=unit value=$housedata.unit}
						{assign var=street value=$housedata.street}
						{assign var=area value=$housedata.area}
						{assign var=record_id value=$housedata.record_id}
						
						<td class="dvtCellInfo"><a href="index.php?module=House&action=DetailView&record={$record_id}" title="House">{$house_no}</a></td>
						<td class="dvtCellInfo">{$unit}</td>
						<td class="dvtCellInfo">{$street}</td>
						<td class="dvtCellInfo">{$area}</td>
				</tr>
			{/foreach}
		</table>
	</div>