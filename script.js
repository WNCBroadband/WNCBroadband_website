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
//var tiles = new L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png').addTo(map);
survey_results = L.tileLayer('https://api.mapbox.com/styles/v1/bsowka/cjwocd1z63y0s1co8t3j8pxws/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYnNvd2thIiwiYSI6ImNqcjBzaXR1NDBzYnY0YWxzaDdrajQ1NHYifQ.HTlG0daGz_x9u2dC_sMvig', {
}).addTo(map);

survey_points = L.geoJSON(survey_result_points)

var markers = L.markerClusterGroup();

markers.addLayer(survey_points);

/*
for (var i = 0; i < addressPoints.length; i++) {
    var a = addressPoints[i];
    var title = a[2];
    var marker = L.marker(new L.LatLng(a[0], a[1]), { title: title });
    marker.bindPopup(title);
    markers.addLayer(marker);
}*/
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