<div style="width:auto;display:block;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
		<tr>
			<td class="dvtCellInfo" colspan=2></td>
		</tr>
		<tr>
			<td  class="dvtCellLabel" width="20%">
				<b>Map Location</b>
			</td>
			<td  class="dvtCellInfo" width="80%">
				<style>
					#map-canvas{ldelim}
					  height: 500px;
					{rdelim}
				</style>
				
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
				<script>

					var map;
					 
					function initializeMAP() {ldelim}
						console.log(google.maps.MapTypeId)
						
						var myLatLng = new google.maps.LatLng({$LATCENTER},{$LNGCENTER});
						var mapOptions = {ldelim}
						  zoom: 15,
						  center: myLatLng,
						  mapTypeId: google.maps.MapTypeId.ROADMAP,
						
						{rdelim};
						 map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
						 
						 addMarker(new google.maps.LatLng({$LAT}, {$LNG}));
					{rdelim}
					
							
					function addMarker(location) {ldelim}
					marker = new google.maps.Marker({ldelim}
								position: location,
								map: map
								{rdelim});
								
								
					google.maps.event.addListener(marker, 'click', function() {ldelim}
						map.setZoom(18);
						map.setCenter(marker.getPosition());
						map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
						{rdelim});	

				    {rdelim}

				</script>
				<div id="map-canvas">awdawd</div>
			</td>
		</table>
</div>