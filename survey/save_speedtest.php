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
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script> 
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../css/style.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <? 
    // $path = $_SERVER['DOCUMENT_ROOT'];
    // $path .= "/common/header.php";
    // include_once($path);
    
    //ini_set('display_errors', true);
    //error_reporting(E_ALL);
    include('../db.php');
    require('./map_resources/js/geocode_s0.php');
    
    
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
	<?php include("http://www.wncbroadband.org/includes/nav_main_core.php");?>

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
	<?php include("http://www.wncbroadband.org/includes/footer.php");?>
	<script>
		function goBack() {
  			window.history.go(-2);
		}
	</script>

</body>
</html>
