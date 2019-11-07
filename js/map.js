// Initialize the map and assign it to a variable for later use
var map = L.map('map', {
    // Set latitude and longitude of the map center (required)
    center: [35.502,-82.528], 
    // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
    zoom: 9
});

L.control.scale().addTo(map);

// Create a Tile Layer and add it to the map
//var tiles = new L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png').addTo(map);
L.tileLayer('https://api.mapbox.com/styles/v1/bsowka/cjwocej426m0a1cpiyc04jpqr/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYnNvd2thIiwiYSI6ImNqcjBzaXR1NDBzYnY0YWxzaDdrajQ1NHYifQ.HTlG0daGz_x9u2dC_sMvig', {
}).addTo(map);


  var searchControl = new L.esri.Controls.Geosearch().addTo(map);

  var results = new L.LayerGroup().addTo(map);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });

setTimeout(function(){$('.pointer').fadeOut('slow');},3400);



//This Function is an if then that allows cycling between different maps.
function mapSwitch(){
	if (document.getElementById("map1").checked){
			
		//The default map goes here~!
			L.tileLayer('https://api.mapbox.com/styles/v1/bsowka/cjsk5mt8s2yp01gp6jq7fkz07/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYnNvd2thIiwiYSI6ImNqcjBzaXR1NDBzYnY0YWxzaDdrajQ1NHYifQ.HTlG0daGz_x9u2dC_sMvig', {	
			}).addTo(map);

			console.log("map 1 is checked and loaded");
	
	} else if 
		(document.getElementById("map2").checked){
			
			L.tileLayer('https://api.mapbox.com/styles/v1/mwilson3/cjsbs2l9c189c1ftbrzrrlk30/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoibXdpbHNvbjMiLCJhIjoiY2pyMHNrMHR5MHNmeTN5cXF4cmk0dTNpaiJ9.IrVUHrCHf8jdwV9RcYym_w', {
			}).addTo(map);
			
			console.log("map 2 is checked and loaded");
			
	} else if 
		(document.getElementById("map3").checked){
			
			L.tileLayer('https://api.mapbox.com/styles/v1/mwilson3/cjsbs6amg15801go76ls8btsf/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoibXdpbHNvbjMiLCJhIjoiY2pyMHNrMHR5MHNmeTN5cXF4cmk0dTNpaiJ9.IrVUHrCHf8jdwV9RcYym_w', {
			}).addTo(map);
			
			console.log("map 3 is checked and loaded");
			
	} else if 
		(document.getElementById("map4").checked){
			
			L.tileLayer('https://api.mapbox.com/styles/v1/mwilson3/cjsbs6ifr0in81gtla5dxk7vr/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoibXdpbHNvbjMiLCJhIjoiY2pyMHNrMHR5MHNmeTN5cXF4cmk0dTNpaiJ9.IrVUHrCHf8jdwV9RcYym_w', {
			}).addTo(map);
			
			console.log("map 4 is checked and loaded");
			
	} else {
		console.error("The Map Switching Mechanic is Broken.");
	}
}

mapSwitch;

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("This is the current mbps for this area is:" )
        .openOn(map);
}
map.on('click', onMapClick);





