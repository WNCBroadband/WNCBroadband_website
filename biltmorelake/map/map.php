<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Area Map</title>
   
  <!--	Leaflet CSS	-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"/>
	
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../js/jquery.min.js"></script> 	
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../css/style.css" rel="stylesheet" type="text/css">
	
  <!--	Lealet Javascript	-->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <script src="leaflet.featuregroup.subgroup.js"></script>

  <!--	Leaflet Stylesheets	-->
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dblue fixed-top stroke">
    <div class="container">
      <a class="navbar-brand" href="../index.html">
        <img src="../img/wncbroadbandlogo.png" width="100px" alt="WNC Broadband Project Logo Image and Link">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="../aboutproject.html">WNC Broadband Project</a></li>
              <li><a class="dropdown-item" href="../aboutBiltmoreLake.html">Biltmore Lake</a></li>
           </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../broadband101.html">Broadband 101</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../101links.html">Resources</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../providers.html">Service Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../faq.html">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contact.html">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Area Maps</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item active" href="../map/map.html">Biltmore Lake</a></li>
           </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<!--	END NAVBAR	-->

	
<!--	MAP		-->
  	<div id="map"></div>
	<div id="mapKey">
		<ul><h3>Map Key</h3>
			<li><img src="img/pin_gray.png" height="20px" width="20px"> 	Gray: Unknown Speed</li>
			<li><img src="img/pin_red.png" height="20px" width="20px">		Red: Less than 5 Mpbs</li>
			<li><img src="img/pin_orange.png" height="20px" width="20px">	Orange: Between 5 and 25 Mbps </li>
			<li><img src="img/pin_yellow.png" height="20px" width="20px">	Yellow: Between 25 and 90 Mbps</li>
			<li><img src="img/pin_green.png" height="20px" width="20px">	Green: Greater than 90 Mbps</li>
		</ul>
	</div>
        <!--	MAP	END		-->

	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <?php
        if(isset($_GET['survey_id']) && !empty($_GET['survey_id'])){
    echo '<script src="survey_data.php?survey_id='.$_GET['survey_id'].'"></script>';
        }else{
    echo '<script src="survey_data.php?survey_id=1"></script>';
        }
    ?>
    <script  src="script.js"></script>
	
	<!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	  


</body>
</html>
