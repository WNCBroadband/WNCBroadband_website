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

var survey_points = L.geoJSON(survey_result_points);
console.log(survey_points);
console.log(survey_result_points);
var features = (survey_result_points["features"]);
console.log((features[0]["geometry"]["coordinates"][0]) +", "+ (features[0]["geometry"]["coordinates"][1]));

//console.log(survey_result_points[features]);
var markers = new L.markerClusterGroup();

//markers.addLayer(survey_points);

markers.on('clusterclick', function (a) {
    a.layer.zoomToBounds({padding: [20,20]});
});

//for (var i = 0; i < markers.length; i++) {
//		var a = markers[i];
//		var title = a[2];
//		var marker = L.marker(L.latLng(a[0], a[1]), { properties: properties });
//		marker.bindPopup("properties");
//		markers.addLayer(marker);
//	console.log("interation" + i)
//}

var LeafIcon = L.Icon.extend({
    options: {
       iconSize:     [38, 95],
       shadowSize:   [50, 64],
       iconAnchor:   [22, 94],
       shadowAnchor: [4, 62],
       popupAnchor:  [-3, -76]
    }
});

var greenIcon = new LeafIcon({
    iconUrl: 'http://leafletjs.com/examples/custom-icons/leaf-green.png',
    shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
});

var blue_markers = [];
var green_markers = [];
var red_markers = [];
var blueSubGroup = L.featureGroup.subGroup(markers, blue_markers);
var greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
//var redSubGroup = L.featureGroup.subGroup(markers, red_markers);

function makeMarkers(thing){
	for (var i = 0; i < thing.length; i++) {
		var downspeed = (thing[i]["properties"]["download_speed"]);
		var upspeed = (thing[i]["properties"]["upload_speed"]);
		
		var green_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon: greenIcon
		});
		var blue_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
		});
		
		//marker.bindPopup(downspeed);
		if(downspeed < 5){
			green_markers.push(green_marker);
		} else {
			blue_markers.push(blue_marker);
		}
//		console.log("interation" + (i-1));
	}
	//markers.addLayers(green_markers,blue_markers);
	blueSubGroup = L.featureGroup.subGroup(markers, blue_markers);
	greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
	//redSubGroup = L.featureGroup.subGroup(markers, red_markers);

}

makeMarkers(features);

map.addLayer(markers);
map.addLayer(blueSubGroup);
map.addLayer(greenSubGroup);

//redSubGroup.addto(map);

//console.log(markers);

//implentation of the search function
//function search(){
//	var searchControl = new L.esri.Controls.Geosearch().addTo(map);
//	var results = new L.LayerGroup().addTo(map);
//	searchControl.on('results', function(data){
//		results.clearLayers();
//		for (var i = data.results.length - 1; i >= 0; i--) {
//		  results.addLayer(L.marker(data.results[i].latlng));
//		}
//	  });
//
//	setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
//}
//search();



