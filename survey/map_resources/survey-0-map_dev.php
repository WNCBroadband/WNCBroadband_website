<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Area Map</title>
   
  <!--  Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"/>
  
  <!-- Bootstrap core CSS -->
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../../vendor/jquery/jquery.min.js"></script>   
  <!-- Bootstrap core CSS -->
  <link href="../../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../../css/style.css" rel="stylesheet" type="text/css">
  
  <!--  Lealet Javascript -->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <script src="js/leaflet.featuregroup.subgroup.js"></script>

  <!--  Leaflet Stylesheets -->
  <link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
  <link href="../../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" rel="stylesheet">
  
  <!-- Custom fonts for this template -->
  <link href="../../vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template -->
  <link href="../../css/landing-page.min.css" rel="stylesheet">
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <link rel="stylesheet" href="css/survey-0-mapstyle.css">
</head> 

<body>
  <? 
    $map_geoip_latitude = $_GET['geoip_latitude'];
    $map_geoip_longitude = $_GET['geoip_longitude'];
  ?>
<!--  MAP   -->
    <div id="map"></div>
      <div class="mapkey">
      <button type="button" class="mapkeycollapsible"><h3>Map Key</h3></button>
      <div class="mapkeycontent"> 
        <h5>Download Speed:</h5> testing
        <ul>
      <li><img src="js/img/pin_gray.png" height="20px" width="20px">   Gray: Unknown Speed</li>
      <li><img src="js/img/pin_red.png" height="20px" width="20px">    Red: Less than 5 Mpbs</li>
      <li><img src="js/img/pin_orange.png" height="20px" width="20px"> Orange: Between 5 and 25 Mbps </li>
      <li><img src="js/img/pin_yellow.png" height="20px" width="20px"> Yellow: Between 25 and 90 Mbps</li>
      <li><img src="js/img/pin_green.png" height="20px" width="20px">  Green: Greater than 90 Mbps</li>
        </ul>
      </div>
      </div>
        <!--  MAP END   -->

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <?php
        if(isset($_GET['survey_id']) && !empty($_GET['survey_id'])){
    echo '<script src="js/survey_0_data.php?survey_id='.$_GET['survey_id'].'"></script>';
        }else{
    echo '<script src="js/survey_0_data.php?survey_id=0"></script>';
        }
    ?>
  <script type="text/javascript">
    console.log(<?= json_encode($map_geoip_latitude); ?>);
    console.log(<?= json_encode($map_geoip_longitude); ?>);

    var center1 = (<?= json_encode($map_geoip_latitude);?>);
    var center2 = (<?= json_encode($map_geoip_longitude);?>);
    geo_center = new L.LatLng(center1, center2);
    console.log(geo_center);

  </script>

    <script  src="js/survey-0-map-script.js"></script>
<script>
  map.setView(geo_center);
</script>
    <script src="js/survey-0-mapkey.js"></script>
  
  <!-- Bootstrap core JavaScript -->
  <script src="../../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
