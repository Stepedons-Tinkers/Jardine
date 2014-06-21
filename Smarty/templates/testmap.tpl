&#&#&#&#&#&#
    <style>
		html, body {ldelim}
		  height: 100%;
		  margin: 0;
		  padding: 0;
		{rdelim}

		#map-canvas, #map_canvas {ldelim}
		  height: 80%;
		{rdelim}

		@media print {ldelim}
		  html, body {ldelim}
			height: auto;
		  {rdelim}

		  #map_canvas {ldelim}
			height: 650px;
		  {rdelim}
		{rdelim}
	</style>
  <body>
	<button  onclick="__initialize()">here</button>
    <div id="map-canvas"></div>
	<!-- latlang: <input id="lat" type="text" style="width:300px"> -->
	<div id="terrain"></div>
  </body>

&#&#&#