// Initialize the map and assign it to a variable for later use
var map = L.map('map', {
    // Set latitude and longitude of the map center (required)
    center: [35.502,-82.528], 
    // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
    zoom: 9,
    maxZoom: 15
});

L.control.scale().addTo(map);
$(".leaflet-control-zoom").css("visibility","hidden");
// Create a Tile Layer and add it to the map

survey_results = L.tileLayer('https://api.mapbox.com/styles/v1/westngn/ck2z53u892diw1cldqewni6bg/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid2VzdG5nbiIsImEiOiJjanVzc3I1Zm8wMG5mNDNrZnl1aGt5cmhvIn0.0AULTTBaoxcqci1Iie9IDA', {
}).addTo(map);

survey_points = L.geoJSON(survey_result_points)

var markers = L.markerClusterGroup();

markers.addLayer(survey_points);

markers.on('clusterclick', function (a) {
    a.layer.zoomToBounds({padding: [20,20]});
});

map.addLayer(markers);

  var searchControl = new L.esri.Controls.Geosearch().addTo(map);

  var results = new L.LayerGroup().addTo(map);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });

setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
