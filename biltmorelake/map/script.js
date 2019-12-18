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
var features = (survey_result_points["features"]); //this gets the features dictionary which contains "geometry"(latlng) and "properties"(speed results)  
var markers = new L.markerClusterGroup();

markers.on('clusterclick', function (a) {
    a.layer.zoomToBounds({padding: [20,20]});
});

//making a new icon
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
    iconUrl: 'http://leafletjs.com/examples/custom-icons/leaf-green.png', //to be changed
    shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
});

var blue_markers = []; //These arrays will hold a bunch of Marker objects
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
		
		//This if statement determines the color of the marker based on speed
		if(downspeed < 5){
			green_markers.push(green_marker); //Pushes to an array of markers, this is what the Subgroup Plugin takes as its second parameter
		} else {
			blue_markers.push(blue_marker);
		}
	}
	blueSubGroup = L.featureGroup.subGroup(markers, blue_markers);
	greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
	//redSubGroup = L.featureGroup.subGroup(markers, red_markers);

}
makeMarkers(features);

map.addLayer(markers);
map.addLayer(blueSubGroup);
map.addLayer(greenSubGroup);
//redSubGroup.addto(map);


//Search function broke because of multiple marker types

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



