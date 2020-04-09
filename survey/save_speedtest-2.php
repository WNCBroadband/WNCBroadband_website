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

</head>

<body>
<? 
 $path = $_SERVER['DOCUMENT_ROOT'];
 $path .= "/common/header.php";
 include_once($path);

ini_set('display_errors', true);
error_reporting(E_ALL);
$geocode_path = './map_resources/js/geocode_s0.php';
require($geocode_path);


$saved_response_id  = $_GET['response_id'];
$saved_geoip_latitude = $_GET['geoip_latitude'];
$saved_geoip_longitude = $_GET['geoip_longitude'];
$saved_user_address = $_GET['user_address'];

set_address($saved_user_address);
geocode($saved_user_address);
?>

<script>
    console.log(<?= json_encode($saved_response_id); ?>);
    console.log(<?= json_encode($saved_geoip_latitude); ?>);
    console.log(<?= json_encode($saved_geoip_longitude); ?>);
    console.log(<?= json_encode($saved_user_address); ?>);
</script>


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
            <a class="nav-link" href="../advocacy.html">Actions We Can Take</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
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

  <div class="parent-container">
    <iframe class="survey-0-map-container" src="map_resources/survey-0-map.php?geoip_latitude=<?php echo $saved_geoip_latitude ?>&geoip_longitude=<?php echo $saved_geoip_longitude ?>">
    </iframe>
  </div>

</section>

<div class="separate"></div>

<footer class="footer bg-dblue text-white pt-5">
    <div class="container">
      <div class="row">
      <div class="col-6 col-sm-3">
        <ul>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/">Home</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../aboutproject.html">About</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../faq.html">FAQ</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../contact.html">Contact</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../broadband101.html">Broadband 101</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li><br>
        </ul>
      </div>
      <div class="col-6 col-sm-3">
        <ul>
          <li class="list-inline-item">
          <a href="speedtest.php">Speed Test</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../advocacy.html">Actions We Can Take</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../getinvolved.html">Get Involved</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../101links.html">Resources</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/blog/">News</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/archives/">Archives</a>
          </li><br>
        </ul>
      </div>
      <div class="col-3">
      </div>
      <div class="col-3">
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
