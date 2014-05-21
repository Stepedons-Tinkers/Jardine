<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/Mail.js"></script>
<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>
<script type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<script language="JavaScript" type="text/javascript" src="include/jquery/jquery-ui.js"></script>
<script src="include/amcharts/amcharts/amcharts.js" type="text/javascript"></script>   
<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr>
		<td>
				<br>
				<br>
				<br>

			<!-- Contents -->
			<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
				<tr>
					<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>
					<td class="showPanelBg" valign=top width=100%>
						<!-- PUBLIC CONTENTS STARTS-->
						<br>
						<br>
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
								<tr>
									<td>
										<span class="dvHeaderText">&nbsp;&nbsp;KHA Reports</span>
									</td>
								</tr>
						</table>
						<br>
						
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
							<tr>
								<td width="20%" valign="top">
									<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" style="padding:10px; min-width=200px;" class="searchUIBasic">
										{foreach item=record_name key=record_id from=$REPORTSARR}
											<tr ><td width="95%" {if $record_id neq $ID}class="tabUnSelected"{else}class="tabSelected"{/if} height=20px><a href="index.php?module=ReportsKHA&action=HomePage&record={$record_id}">{$record_name}</b></td></tr>
										{/foreach}
									</table>
								</td>
								<td width="80%">
									<div id="reportContainer" width=100%>
										{if $REPORTVIEW != ''}
											{include file=$REPORTVIEW}
										{else}
											Please Select Report
										{/if}
									</div>
								</td>
							</tr>
							
						</table>
						
						<br>
					</td>
					<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
