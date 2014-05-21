	<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
		<tr>{strip}
		<td colspan=4 class="dvtCellLabel" >

			<div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus('tblcar','aidcar','{$IMAGE_PATH}');">
						{if $BLOCKINITIALSTATUS[$header] eq 1}
							<img id="aidcar" src="{'activate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>
						{else}
							<img id="aidcar" src="{'inactivate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Display" title="Display"/>
						{/if}
					</a></div><b>&nbsp;
					Other Cars
				</b></div>
		</td>{/strip}
		</tr>
	</table>

	{if $BLOCKINITIALSTATUS[$header] eq 1}
	<div style="width:auto;display:block;" id="tblcar" >
	{else}
	<div style="width:auto;display:none;" id="tblcar" >
	{/if}
	
		<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
			<tr>
				<td class="dvtCellLabel">Car No.</td>
				<td class="dvtCellLabel">Plate No.</td>
				<td class="dvtCellLabel">Status</td>
				<td class="dvtCellLabel">Date of Renewal</td>
			</tr>
			{foreach item=cardata key=carrecord from=$CARs}
				<tr>
						{assign var=car_no value=$cardata.car_no}
						{assign var=plate_no value=$cardata.plate_no}
						{assign var=c_status value=$cardata.c_status}
						{assign var=record_id value=$cardata.record_id}
						{assign var=date_of_renewal value=$cardata.date_of_renewal}
						<td class="dvtCellInfo"><a href="index.php?module=Cars&action=DetailView&record={$record_id}" title="car">{$car_no}</a></td>
						<td class="dvtCellInfo">{$plate_no}</td>
						<td class="dvtCellInfo">{$c_status}</td>
						<td class="dvtCellInfo">{$date_of_renewal}</td>
				</tr>
			{/foreach}
		</table>
	</div>