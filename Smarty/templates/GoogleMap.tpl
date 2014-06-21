<style>
	#map-canvas{ldelim}
	  height: 500px;
	{rdelim}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>

	var map;
	var markers = [];
	 
	function initializeMAP() {ldelim}
	
		console.log(google.maps.MapTypeId)
		
        var myLatLng = new google.maps.LatLng({$LATCENTER},{$LNGCENTER});
        var mapOptions = {ldelim}
          zoom: 15,
          center: myLatLng,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		
        {rdelim};
		
		 map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
		 
		google.maps.event.addListener(map, 'click', function( event ){ldelim}
		  jQuery("[name='latitude']").val(event.latLng.lat());
		  jQuery("[name='longitude']").val(event.latLng.lng());
		  var location = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
		  removeMarkers();
		  addMarker(location);
		{rdelim});
		
		
		/* If mode is edit */
		initializeLocation();
	{rdelim}
	
			
	function addMarker(location) {ldelim}
	console.log(location)
	marker = new google.maps.Marker({ldelim}
		position: location,
		map: map
	{rdelim});
	markers.push(marker);
   {rdelim}
   
   
	function removeMarkers(){ldelim}
		for (var i = 0; i < markers.length; i++) {ldelim}
		  markers[i].setMap(null);
		{rdelim}
		markers.length=0;
	 {rdelim}
	 
	 function initializeLocation(){ldelim}
		lat = jQuery("[name='latitude']").val();
		lng = jQuery("[name='longitude']").val();
		if(lat != '' && lng != ''){ldelim}
				 addMarker(new google.maps.LatLng(lat, lng));
		{rdelim}
	 {rdelim}
	 
	 
</script>
<div id="map-canvas"></div>