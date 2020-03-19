<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WNC Broadband Project | Survey</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script> 
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../css/style.css" rel="stylesheet" type="text/css">

    <!--  Lealet Javascript -->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <script src="map_resources/js/leaflet.featuregroup.subgroup.js"></script>

  <!--  Leaflet Stylesheets -->
  <link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" rel="stylesheet">
    
  <!-- Custom styles for this template -->
  <!-- <link href="../css/landing-page.min.css" rel="stylesheet"> -->
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <link rel="stylesheet" href="map_resources/css/survey-0-mapstyle.css">

</head>

<body>

  <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dblue fixed-top stroke">
    <div class="container">
      <a class="navbar-brand" href="https://wncbroadband.org/blog/">
        <img src="../img/wncbroadbandlogo.png" width="100px" alt="WNC Broadband Project Logo Image and Link">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/">Home</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="../aboutproject.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../broadband101.html">Broadband 101</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/archives/">Archives</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../101links.html">Resources</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../faq.html">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <section class="p-5"></section>
<section class="header pt-5">  
  <div class="custom-container pb-5">
        <h1 class="mt-3 mb-5 text-center">Thank you for taking the speed test!</h1>
        <p class="lead">Thank you for contributing your speed data for our community mapping projects.</p><br>
        <br>
        <button class="btn btn-primary mb-5" onclick="goBack()">Go Back</button>
        <br><br>
  </div>

  <div class="map-survey-0-container">
      <div id="map"></div>
      <div class="mapkey">
      <button type="button" class="mapkeycollapsible"><h3>Map Key</h3></button>
      <div class="mapkeycontent"> 
        <h5>Download Speed:</h5>
        <ul>
      <li><img src="map_resources/js/img/pin_gray.png" height="20px" width="20px">   Gray: Unknown Speed</li>
      <li><img src="map_resources/js/img/pin_red.png" height="20px" width="20px">    Red: Less than 5 Mpbs</li>
      <li><img src="map_resources/js/img/pin_orange.png" height="20px" width="20px"> Orange: Between 5 and 25 Mbps </li>
      <li><img src="map_resources/js/img/pin_yellow.png" height="20px" width="20px"> Yellow: Between 25 and 90 Mbps</li>
      <li><img src="map_resources/js/img/pin_green.png" height="20px" width="20px">  Green: Greater than 90 Mbps</li>
        </ul>
      </div>
      </div>
      <?php
        if(isset($_GET['survey_id']) && !empty($_GET['survey_id'])){
          echo '<script src="map_resources/js/survey_0_data.php?survey_id='.$_GET['survey_id'].'"></script>';
        }else{
          echo '<script src="map_resources/js/survey_0_data.php?survey_id=0"></script>';
      }
      ?>
      <script  src="map_resources/js/survey-0-map-script.js"></script>
      <script src="map_resources/js/survey-0-mapkey.js"></script>
</div>

</section>

<div class="separate"></div>

<footer class="footer bg-dblue text-white pt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6 text-right">
          <ul>
            <li class="list-inline-item">
              <a href="https://wncbroadband.org/blog">Home</a>
            </li><br>
            <li class="list-inline-item">
              <a href="https://wncbroadband.org/blog/blog">News</a>
            </li><br>
            <li class="list-inline-item">
              <a href="https://wncbroadband.org/blog/archives">Archives</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../101links.html">Resources</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../faq.html">FAQ</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../contact.html">Contact</a>
            </li><br>
          </ul>
        </div>
        <div class="col-12 text-center">
        <p>&copy; 2020 WNC Broadband Project | <a href="../privacypolicy.html"> Privacy Policy</a></p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
function goBack() {
  window.history.go(-2);
}
</script>

</body>

</html>
