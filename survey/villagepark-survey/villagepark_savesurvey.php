<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-164513870-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-164513870-1');
</script>


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WNC Broadband Project | Survey</title>

  <!-- Bootstrap core CSS -->
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../../js/jquery.min.js"></script> 
  <!-- Bootstrap core CSS -->
  <link href="../../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include('../../db.php');
require('../../survey/map_resources/js/geocode_s0.php');

$saved_response_id  = $_GET['response_id'];
$saved_geoip_latitude = $_GET['geoip_latitude'];
$saved_geoip_longitude = $_GET['geoip_longitude'];
$saved_user_address = $_GET['user_address'];

$geocode_variables = geocode($saved_user_address);
if ($geocode_variables!=false){
  update_response_geoip($geocode_variables[0],$geocode_variables[1], $saved_response_id);
  $saved_geoip_latitude = $geocode_variables[0];
  $saved_geoip_longitude = $geocode_variables[1];
}

if ($saved_geoip_latitude==0 || $saved_geoip_longitude == 0){
  $saved_geoip_latitude = 35.5951;
  $saved_geoip_longitude = -82.5515;
}

?>

<script>
    console.log(<?= json_encode($saved_response_id); ?>);
    console.log(<?= json_encode($saved_geoip_latitude); ?>);
    console.log(<?= json_encode($saved_geoip_longitude); ?>);
    console.log(<?= json_encode($saved_user_address); ?>);
</script>


  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-dblue navbar-dark mainnav">
      <a class="navbar-brand" href="https://wncbroadband.org/blog">
        <img src="../../img/wncbroadbandlogo.png" alt="WNC Broadband Project Logo Image and Link" class="img-fluid logo">
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
            <a class="nav-link" href="../../advocacy.html">Actions We Can Take</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
          </li>
        </ul>
  </div>
</nav>

<nav class="navbar navbar-expand-md bg-lblue navbar-dark communitynav">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 <div class="collapse navbar-collapse navbars" id="navbar2">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../../villagepark/index.html">Village Park</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../villagepark/aboutVillagePark.html">About Community</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="survey.html">Survey</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../villagepark/providers.html">Service Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../villagepark/communitycontacts.html">Community Contacts</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Village Park Maps</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="../../villagepark/map/villageparkmap.php">Speed Test Results</a></li>
            <!--<li><a class="dropdown-item" href="../map/map.html">Services Offered</a></li>-->
           </ul>
          </li>
        </ul>
      </div>
  </nav>

  <!-- Page Content -->
  <section class="p-3"></section>
<section class="header">  
  <div class="custom-container">
        <h1 class="mt-3 mb-5 text-center">Thank you for taking our survey!</h1>
        <p class="lead">Thank you for your participation in this survey. <br>
        Learn more about how you can get involved and get further engaged in broadband issues <a href="../../villagepark/getinvolved.html"><b>here</b></a>.<br><br>
        <a href="../../villagepark/index.html">Return to community homepage</a></p>
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
          <a href="../../aboutproject.html">About</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../faq.html">FAQ</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../contact.html">Contact</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../broadband101.html">Broadband 101</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li><br>
        </ul>
      </div>
      <div class="col-6 col-sm-3">
        <ul>
          <li class="list-inline-item">
          <a href="../../survey/speedtest.php">Speed Test</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../advocacy.html">Actions We Can Take</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../getinvolved.html">Get Involved</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../101links.html">Resources</a>
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
        <p>&copy; 2020 WNC Broadband Project | <a href="../../privacypolicy.html"> Privacy Policy</a></p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript -->

</body>

</html>
