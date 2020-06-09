<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Area Map</title>
   
  <!--  Leaflet CSS -->
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
  <link href="../../css/style.css" rel="stylesheet" type="text/css">
  
  <!--  Lealet Javascript -->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <script src="leaflet.featuregroup.subgroup.js"></script>

  <!--  Leaflet Stylesheets -->
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
  <nav class="navbar navbar-expand-lg bg-dblue navbar-dark mainnav2">
      <a class="navbar-brand" href="https://wncbroadband.org/blog">
        <img src="../img/wncbroadbandlogo.png" alt="WNC Broadband Project Logo Image and Link" class="img-fluid logo" width="100px">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse navbars pull-right" id="navbar1">
        <ul class="navbar-nav ml-auto small">
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../aboutproject.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../broadband101.html">Broadband 101</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/advocacy/">Actions We Can Take</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
          </li>
        </ul>
  </div>
</nav>

<nav class="navbar navbar-expand-md bg-lblue navbar-dark communitynav2">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 <div class="collapse navbar-collapse navbars" id="navbar2">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../index.html">Upper Hominy</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../aboutUpperHominy.html">About Community</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../survey/upperhominy-survey/survey.html">Survey</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../providers.html">Service Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../communitycontacts.html">Community Contacts</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upper Hominy Maps</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="/upperhominy/map/uhMap.php">Speed Test Results</a></li>
            <li><a class="dropdown-item" href="/upperhominy/map/uhMap2.php">Services Offered</a></li>
           </ul>
          </li>
        </ul>
      </div>
  </nav>
<!--  END NAVBAR  -->

  
<!--  MAP   -->
    <div class="service_myMap" id="myMap">
      <iframe src="https://www.google.com/maps/d/embed?mid=1flxLQ_YedeeBeRa0VjIJShCTDSlQVmLl" width="100%" height="100%"></iframe>
    </div>
        <!--  MAP END   -->


  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script  src="uhMapScript.js"></script>
    <script src="mapkey.js"></script>
  
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    


</body>
</html>
