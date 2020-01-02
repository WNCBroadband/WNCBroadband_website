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

var features = (survey_result_points["features"]); //this gets the features dictionary which contains "geometry"(latlng) and "properties"(speed results)  
var markers = new L.markerClusterGroup();

markers.on('clusterclick', function (a) {
    a.layer.zoomToBounds({padding: [20,20]});
});

//making a new icon
var PinIcon = L.Icon.extend({
    options: {
       iconSize:     [38, 95],
       shadowSize:   [50, 64],
       iconAnchor:   [22, 94],
       shadowAnchor: [4, 62],
       popupAnchor:  [-3, -76]
    }
});

var greenIcon = new PinIcon({
    iconUrl: 'http://westngn.org/biltmorelake/map/img/pin_green.png', //to be changed
    //shadowUrl: ''
});
var redIcon = new PinIcon({
    iconUrl: 'http://westngn.org/biltmorelake/map/img/pin_red.png', //to be changed
    //shadowUrl: ''
});
var orangeIcon = new PinIcon({
    iconUrl: 'img/pin_orange', //to be changed
    //shadowUrl: ''
});
var yellowIcon = new PinIcon({
    iconUrl: 'img/pin_yellow', //to be changed
    //shadowUrl: ''
});

var orange_markers = []; //These arrays will hold a bunch of Marker objects
var green_markers = [];
var red_markers = [];
var yellow_markers = [];

var orangeSubGroup = L.featureGroup.subGroup(markers, orange_markers);
var greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
var redSubGroup = L.featureGroup.subGroup(markers, red_markers);
var yellowSubGroup = L.featureGroup.subGroup(markers, yellow_markers);

function makeMarkers(thing){
	for (var i = 0; i < thing.length; i++) {
		var downspeed = (thing[i]["properties"]["download_speed"]);
		var upspeed = (thing[i]["properties"]["upload_speed"]);
		
		var green_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon: greenIcon
		});
		var red_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon: redIcon
		});
		var orange_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon: orangeIcon
		});
		var yellow_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon: yellowIcon
		});
		
		//This if statement determines the color of the marker based on speed
		if(downspeed < 5){
			red_markers.push(red_marker); //Pushes to an array of markers, this is what the Subgroup Plugin takes as its second parameter
//		} else if(downspeed >= 5 && downspeed < 25){
//			orange_markers.push(orange_marker);
//		} else if(downspeed >= 25 && downspeed < 90){
//			yellow_markers.push(yellow_marker);
//		} else {
//			green_markers.push(green_marker);
		}
	}
	orangeSubGroup = L.featureGroup.subGroup(markers, orange_markers);
	greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
	redSubGroup = L.featureGroup.subGroup(markers, red_markers);
	yellowSubGroup = L.featureGroup.subGroup(markers, yellow_markers);

}
makeMarkers(features);

map.addLayer(markers);
map.addLayer(orangeSubGroup);
map.addLayer(redSubGroup);
map.addLayer(yellowSubGroup);
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



