<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Area Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"/>

  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <script src="leaflet.featuregroup.subgroup.js"></script>

	
  <link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" rel="stylesheet">
	

  <!-- Custom fonts for this template -->
  <link href="../vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template -->
  <link href="../css/landing-page.min.css" rel="stylesheet">
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <link rel="stylesheet" href="../css/mapstyle.css">
</head>	

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-light fixed-top">
    <div class="container">
     <a class="btn" href="../takeTheTest.html"></a>
     <a class="btn" href="map.html"></a>       
      <a class="btn" href="#"></a>
         <li class="list-inline-item">
            <a class="btn" href="../index.html">
            <img src="../img/West_NGN_logo.png" width="100" height="50"></a>
		</li>
    </div>
  </nav>

  	<div id="map"></div>
<div class="pointer">Click search button</div>
        
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <?php
        if(isset($_GET['survey_id']) && !empty($_GET['survey_id'])){
    echo '<script src="survey_data.php?survey_id='.$_GET['survey_id'].'"></script>';
        }else{
    echo '<script src="survey_data.php?survey_id=1"></script>';
        }
    ?>
    <script  src="script.js"></script>


</body>
</html>
