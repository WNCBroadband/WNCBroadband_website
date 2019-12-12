// Initialize the map and assign it to a variable for later use
var map = L.map('map', {
    // Set latitude and longitude of the map center (required)
    center: [35.55,-82.628], 
    // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
    zoom: 9,
    maxZoom: 15
});

L.control.scale().addTo(map);
$(".leaflet-control-zoom").css("visibility","hidden");
// Create a Tile Layer and add it to the map

//Create access token linking to the map on a mappbox account
survey_results = L.tileLayer('https://api.mapbox.com/styles/v1/westngn/ck2z53u892diw1cldqewni6bg/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid2VzdG5nbiIsImEiOiJjanVzc3I1Zm8wMG5mNDNrZnl1aGt5cmhvIn0.0AULTTBaoxcqci1Iie9IDA', {
}).addTo(map);

survey_points = L.geoJSON(survey_result_points);
console.log(survey_points);
console.log(markers);

var markers = L.markerClusterGroup();

markers.addLayer(survey_points);

markers.on('clusterclick', function (a) {
    a.layer.zoomToBounds({padding: [20,20]});
});

for (var i = 0; i < markers.length; i++) {
		var a = markers[i];
		var title = a[2];
		var marker = L.marker(L.latLng(a[0], a[1]), { properties: properties });
		marker.bindPopup("properties");
		markers.addLayer(marker);
}

map.addLayer(markers);

console.log(markers);

//implentation of the search function
var searchControl = new L.esri.Controls.Geosearch().addTo(map);
var results = new L.LayerGroup().addTo(map);
searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });

setTimeout(function(){$('.pointer').fadeOut('slow');},3400);



