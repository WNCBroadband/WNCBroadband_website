// Initialize the map and assign it to a variable for later use
var corner1 = L.latLng(35.544993, -82.676201),
	corner2 = L.latLng(35.519708, -82.610626),
	bounds = L.latLngBounds(corner1, corner2);

var map = L.map('map', {
    // Set latitude and longitude of the map center (required)
    center: [35.532, -82.643], 
    // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
    zoom: 15,
    maxZoom: 18,
	minZoom: 14,
	maxBounds: bounds			//Uncomment to activate binding window to survey area

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
       iconSize:     [20, 20],
//       shadowSize:   [50, 64],
       iconAnchor:   [10, 19],
//       shadowAnchor: [4, 62],
       popupAnchor:  [0, -10]
    }
});

var greenIcon = new PinIcon({
    iconUrl: 'img/pin_green.png', 
    //shadowUrl: ''
});
var redIcon = new PinIcon({
    iconUrl: 'img/pin_red.png', 
    //shadowUrl: ''
});
var orangeIcon = new PinIcon({
    iconUrl: 'img/pin_orange.png', 
    //shadowUrl: ''
});
var yellowIcon = new PinIcon({
    iconUrl: 'img/pin_yellow.png', 
    //shadowUrl: ''
});
var grayIcon = new PinIcon({
    iconUrl: 'img/pin_gray.png', 
    //shadowUrl: ''
});

var orange_markers = []; //These arrays will hold a bunch of Marker objects
var green_markers = [];
var red_markers = [];
var yellow_markers = [];
var gray_markers = [];



var orangeSubGroup = L.featureGroup.subGroup(markers, orange_markers);
var greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
var redSubGroup = L.featureGroup.subGroup(markers, red_markers);
var yellowSubGroup = L.featureGroup.subGroup(markers, yellow_markers);
var graySubGroup = L.featureGroup.subGroup(markers, gray_markers);

var grayPopup = L.popup();


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
		var gray_marker = L.marker(new L.LatLng((thing[i]["geometry"]["coordinates"][1]), (thing[i]["geometry"]["coordinates"][0])), {
			icon:grayIcon
		});

		//This if statement determines the color of the marker based on speed
		if(downspeed < 5){
			red_markers.push(red_marker); //Pushes to an array of markers, this is what the Subgroup Plugin takes as its second parameter
			red_marker.addTo(map).bindPopup("Download Speed: <strong>" + downspeed + "</strong> Mbps<br> Upload Speed: <strong>" + upspeed + "</strong> Mbps");
		} else if(downspeed >= 5 && downspeed < 25){
			orange_markers.push(orange_marker);
			orange_marker.addTo(map).bindPopup("Download Speed: <strong>" + downspeed + "</strong> Mbps<br> Upload Speed: <strong>" + upspeed + "</strong> Mbps");			
		} else if(downspeed >= 25 && downspeed < 90){
			yellow_markers.push(yellow_marker);		
			yellow_marker.addTo(map).bindPopup("Download Speed: <strong>" + downspeed + "</strong> Mbps<br> Upload Speed: <strong>" + upspeed + "</strong> Mbps");
		} else if(downspeed >= 90){
			green_markers.push(green_marker);
			green_marker.addTo(map).bindPopup("Download Speed: <strong>" + downspeed + "</strong> Mbps<br> Upload Speed: <strong>" + upspeed + "</strong> Mbps");
		} else {
			gray_markers.push(gray_marker);
			gray_marker.addTo(map).bindPopup("Download Speed: <strong>Unknown</strong><br> Upload Speed: <strong>Unknown</strong>");			
		}
	}
	orangeSubGroup = L.featureGroup.subGroup(markers, orange_markers);
	greenSubGroup = L.featureGroup.subGroup(markers, green_markers);
	redSubGroup = L.featureGroup.subGroup(markers, red_markers);
	yellowSubGroup = L.featureGroup.subGroup(markers, yellow_markers);
	graySubGroup = L.featureGroup.subGroup(markers, gray_markers);

}
makeMarkers(features);

map.addLayer(markers);
map.addLayer(orangeSubGroup);
map.addLayer(redSubGroup);
map.addLayer(yellowSubGroup);
map.addLayer(greenSubGroup);
map.addLayer(graySubGroup);

//Search function works, just uncomment the last line of code.
//implentation of the search function
function search(){
	var searchControl = new L.esri.Controls.Geosearch().addTo(map);
	var results = new L.LayerGroup().addTo(map);
	searchControl.on('results', function(data){
		results.clearLayers();
		for (var i = data.results.length - 1; i >= 0; i--) {
		  results.addLayer(L.marker(data.results[i].latlng));
		}
	  });

	setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
}
//search();



