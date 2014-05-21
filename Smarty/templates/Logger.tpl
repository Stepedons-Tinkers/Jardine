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
			
						
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%" >
							<tr>
								<td width="35%">
									<table align="center" border="0" cellpadding="10px" cellspacing="0" width="90%">
										<form>
										<tr>
											<td class="dvInnerHeader">
												<span class="dvHeaderText">&nbsp;&nbsp;Car Plate No.</span>
											</td>
										</tr>
										<tr>
											
											<td class="dvtCellInfo">
												
												<center><input type="text" name="carid" style="text-align:center;font-size:25px;width:95%;height:40px;" maxlength="10"/></center>
												<br>
												<center><input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" type="submit" onclick="logcar();return false;" name="button" value=" Log " style="width:100px;height:30px;font-size:12px;" ></center>
											</td>
											
										</tr>
										
										</form>
										
									</table>
								</td>
								
								<td width="65%" valign="top">
									<div id="homeownercontainer">
										{include file = 'HomeownerDetails.tpl'}
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
