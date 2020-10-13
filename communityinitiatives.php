<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="">
  	<meta name="author" content="">
  	<title>WNC Broadband Project | Community Initiatives </title>
  	<!-- Bootstrap core CSS -->
  	<link href="https://wncbroadband.org/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<!-- JQuery -->
  	<script src="https://wncbroadband.org/vendor/jquery/jquery.min.js"></script> 
  	<!-- Bootstrap core CSS -->
  	<link href="https://wncbroadband.org/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  	<!-- Custom fonts for this template -->
  	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  	<!--Site Stylesheet-->
  	<link href="https://wncbroadband.org/css/style.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core JavaScript -->
  	<script src="https://wncbroadband.org/vendor/jquery/jquery.slim.min.js"></script>
  	<script src="https://wncbroadband.org/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>  
</head>

<body>
	<!-- Navigation -->
	<script>
 		var navid = "communityinitiatives";
	</script>
	
	<?php include("http://www.wncbroadband.org/includes/nav_main_core.php");?>

 	<!-- Page Content -->
	<section class="header bg-broad pt-5">  
  		<div class="container pt-5">
  			<div class="row">
  				<div class="col-lg-7">
  					<h1>Community Initiatives</h1>
  				</div>
  			</div>
  		</div>
	</section>
	
	<section class="p-5">
    	<div class="container">
    		<h2></h2>
    		<p class="lead">The WNC Broadband Project is connecting with communities to advocate for better broadband services in these areas. Community members can learn more about the broadband situation in the area and contribute to a survey and speed test. Select your community below to get started.</p>
    		<h5>Individual Communities:</h5>
    		<a class="btn btn-primary mb-5" href="https://wncbroadband.org/biltmorelake/index.html">Biltmore Lake Community ></a>&nbsp;
    		<a class="btn btn-primary mb-5" href="https://wncbroadband.org/upperhominy/index.html">Upper Hominy Community ></a>&nbsp;
    		<a class="btn btn-primary mb-5" href="https://wncbroadband.org/villagepark/index.html">Village Park Community ></a><br>	 	
		Contact us <a href="https://www.wncbroadband.org/contact.php">here</a> to get your community involved in this project.
		</div>
	</section>

<!-- 	
commented out because other drop-down was preferred.	 	
	<section class="p-5 bg-light">
		<div class="container">
			<h2>Countywide Surveys</h2>			
			<p>short blurb about the countywide surveys.</p>
			<select onchange="window.location=this.value">
    			<option value="" disabled selected>Select Your County</option>
        		<option value="https://wncbroadband.org/survey/buncombecounty-survey/take_survey.php">Buncombe</option>
        		<option value="https://wncbroadband.org/survey/cherokeecounty-survey/take_survey.php">Cherokee</option>
                <option value="https://wncbroadband.org/survey/claycounty-survey/take_survey.php">Clay</option>
                <option value="https://wncbroadband.org/survey/grahamcounty-survey/take_survey.php">Graham</option>
                <option value="https://wncbroadband.org/survey/haywoodcounty-survey/take_survey.php">Haywood</option>
                <option value="https://wncbroadband.org/survey/hendersoncounty-survey/take_survey.php">Henderson</option>
                <option value="https://wncbroadband.org/survey/jacksoncounty-survey/take_survey.php">Jackson</option>
                <option value="https://wncbroadband.org/survey/maconcounty-survey/take_survey.php">Macon</option>
                <option value="https://wncbroadband.org/survey/madisoncounty-survey/take_survey.php">Madison</option>
                <option value="https://wncbroadband.org/survey/mcdowellcounty-survey/take_survey.php">McDowell</option>
                <option value="https://wncbroadband.org/survey/polkcounty-survey/take_survey.php">Polk</option>
                <option value="https://wncbroadband.org/survey/swaincounty-survey/take_survey.php">Swain</option>
                <option value="https://wncbroadband.org/survey/transylvaniacounty-survey/take_survey.php">Transylvania</option>
			</select>
		</div>
	</section>	
-->

	<section class="p-5 bg-light">
		<div class="container">
			<h2>Countywide Surveys</h2>			
			<p>Choose your county to take a short survey and provide us with information we can use to increase broadband access in your area</p>
			<style>
                .dropbtn {
                    padding: 16px;
                    font-size: 16px;
                    border: none;
                    cursor: pointer;
                }
                .dropdown {
                    position: relative;
                    display: inline-block;
                }        
                .dropdown-content {
                  display: none;
                  position: absolute;
                  left: 190px;
                  top: 0;
                  background-color: #f1f1f1;
                  min-width: 160px;
                  overflow: auto;
                  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                  z-index: 1;
                }           
                .dropdown-content a {
                  color: black;
                  /* padding: 6px 16px; */
                  text-decoration: none;
                  display: block;
                }
                .dropdown a:hover {
                    background-color: #007bff;
                    color: white;
                }             
                .show {display: block;}
            </style>
			<div class="dropdown">
  				<button onclick="showDrop()" class="dropbtn btn btn-primary mb-5">Select Your County ></button>
  				<div id="dropdownItems" class="dropdown-content">
        			<a href="https://wncbroadband.org/survey/buncombecounty-survey/q1.php">Buncombe</a>
                    <a href="https://wncbroadband.org/survey/cherokeecounty-survey/q1.php">Cherokee</a>
                    <a href="https://wncbroadband.org/survey/claycounty-survey/q1.php">Clay</a>
                    <a href="https://wncbroadband.org/survey/grahamcounty-survey/q1.php">Graham</a>
                    <a href="https://wncbroadband.org/survey/haywoodcounty-survey/q1.php">Haywood</a>
                    <a href="https://wncbroadband.org/survey/hendersoncounty-survey/q1.php">Henderson</a>
                    <a href="https://wncbroadband.org/survey/jacksoncounty-survey/q1.php">Jackson</a>
                    <a href="https://wncbroadband.org/survey/maconcounty-survey/q1.php">Macon</a>
                    <a href="https://wncbroadband.org/survey/madisoncounty-survey/q1.php">Madison</a>
                    <a href="https://wncbroadband.org/survey/mcdowellcounty-survey/q1.php">McDowell</a>
                    <a href="https://wncbroadband.org/survey/polkcounty-survey/q1.php">Polk</a>
                    <a href="https://wncbroadband.org/survey/swaincounty-survey/q1.php">Swain</a>
                    <a href="https://wncbroadband.org/survey/transylvaniacounty-survey/q1.php">Transylvania</a>    			
      			</div>
			</div>       
            <script>
            /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
            function showDrop() {
              document.getElementById("dropdownItems").classList.toggle("show");
            }
            
            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
            </script>      
		</div>
	</section>
	 
	<?php include("http://www.wncbroadband.org/includes/footer.php");?>
</body>
</html>
