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