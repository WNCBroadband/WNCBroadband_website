<?
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
?>
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

	<title>WNC Broadband Project | Speed Test</title>
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

	<script>
    var response_id = -10;
	//Apply a Unique identifier for this page
	function uuidv4() {
    	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      	var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      	return v.toString(16);
      	});
    }
    var uuid = uuidv4();
    var checkbox_limit = 3;
	//Sends the updated results on every change
    function save_question(evt) {
          //console.log(this.className);
          if(this.className.includes('limited-checkbox')){
             if($(".limited-checkbox:checked").length >= checkbox_limit) {
               this.checked = false;
               return false;
             }
          }
      	var xhttp = new XMLHttpRequest();
      	xhttp.onreadystatechange = function() {
      	if (this.readyState == 4 && this.status == 200) {
        	console.log(this.responseText);
        	//parseInt(string)
        	var response_variable = this.responseText.match(/response_id=\d+/);
        	//console.log(response_variable);        
        	response_num = response_variable[0].match(/\d+/);
        	//console.log(response_num);
        	response_id = response_num;
      	}
      };
      xhttp.open("GET", "save_question.php?uuid="+uuid+"&name="+this.name+"&value="+this.value+"&survey_id=0&type="+this.type,true);
      xhttp.send();
      update_geo();
    }
    
    //create an OnChange() for every input element
	function createOnLoad(){
    	var form_e = document.getElementById("fullsurvey");
      	for(var i=0; i < form_e.length; i++) {
        	form_e[i].onchange=save_question;
        	console.log("changed "+form_e[i].name);
        }        
    }
	</script>
</head>


<body onLoad="createOnLoad()">
    <!-- Navigation -->
	<?php include("http://www.wncbroadband.org/includes/nav_main_core.php");?>
	<section class="header bg-broad pt-5">  
  		<div class="container pt-5">
  			<div class="row">
				<div class="col-lg-7">
					<h1>Speed Test</h1>
 				</div>
  			</div>
  	</div>
	</section>	
	<script>
  		var user_in_address;
  		var lat_coord=0;
  		var lng_coord=0;
		//////////////////////////////////////
  		function update_geo(){
    		//unused
    		//document.getElementById('response_id').value = response_id;
    		user_in_address = "" + document.getElementById("street_address").value + ", " + document.getElementById("city_address").value + " "
                        + document.getElementById("state_address").value +  " " + document.getElementById("zip_address").value;
    		console.log(user_in_address);
    		document.getElementById("fullsurvey").action="save_speedtest.php?geoip_latitude="+lat_coord+"&geoip_longitude="+lng_coord+"&user_address="+user_in_address+"&response_id="+response_id;
  		}
		//////////////////////////////////////
	</script>
  	<section class="showcase">
    	<div id="survey-bg" class="container-fluid p-5 row">
        	<div class="mx-auto col-lg-8">
        	</div>
      		<div class="mx-auto col-lg-8">
        		<div class="form-group">
          			<form id="fullsurvey" class="form" method="POST" action="">   
          			<script>
              			update_geo();
          			</script> 
          			<SCRIPT>
          			document.write('<INPUT TYPE="hidden" name="uuid" value="'+uuid+'">');
          			</SCRIPT>
                    <?
                    $servername = "138.68.228.126";
                    $username = "drawertl_westngn";
                    $password = "dbpass_adh4enal";
                    $dbname = "drawertl_westngn";
                    
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    
                    if ($conn->connect_error) {
                        echo("Connection failed: " . $conn->connect_error);
                        exit(0);
                    }
                    ?>			
            		<p class="lead">Broadband service speed and capacity can be distributed unevenly not only across our region, but even in our local communities and neighborhoods. Often, consumers struggle to learn what level of service they and others in their area receive. Moreover, internet service providers are not motivated to share such information with their customers.</p>
            		<p class="lead"> In order to gather this information for consumers to use in communication with their providers, we are constructing a map of broadband speeds in your community. <b>Would you be willing to provide your address for us to display the speed of your internet service on the map? (We will not sell any data).</b></p><br>
					<script>
					function getLocation() {
  						if (navigator.geolocation) {
    						navigator.geolocation.getCurrentPosition(showPosition);
  						}
  						document.getElementById('hidden_address_block').style.display='block';  
					}
					function showPosition(position) {
                    	console.log(position);
                    	document.getElementById('geoip_latitude').value = position.coords.latitude;
                    	document.getElementById('geoip_longitude').value = position.coords.longitude;
                    	lat_coord = position.coords.latitude;
                    	lng_coord = position.coords.longitude;
                    	update_geo();
						var xhttp = new XMLHttpRequest();
  						xhttp.onreadystatechange = function() {
    						if (this.readyState == 4 && this.status == 200) {
      							console.log(this.responseText);
    						}
  						};
  						xhttp.open("GET", "save_question.php?uuid="+uuid+"&survey_id=0&geoip_latitude="+position.coords.latitude+"&geoip_longitude="+position.coords.longitude);
  						xhttp.send();
					}
					</script>
    				<input required name="permission" type="radio" onclick="getLocation()">&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  	<input required name="permission" type="radio">&nbsp;&nbsp;No
    				<input type=hidden id="response_id" name="response_id" value="">
                    <input type=hidden id="geoip_latitude" name="geoip_latitude" value="">
                    <input type=hidden id="geoip_longitude" name="geoip_longitude" value="">
      				<DIV id="hidden_address_block" style="display:none">
                        Street Address <INPUT class="form-control" name="street_address" id="street_address" type="text"><BR>
                        City <INPUT class="form-control" name="city_address" id="city_address" type="text"><BR>
                        State <INPUT class="form-control" name="state_address" id="state_address" type="text"><BR>
                        Zip Code<INPUT class="form-control" name="zip_address" id="zip_address" type="text"><BR>
      				</DIV>
              		<br><br>
        			<div class="q-break"></div><br>
          			<p class="lead">There are major issues in broadband delivery concerning where broadband is available and what the actual speeds are delivered by providers. We are working on ways to determine the speeds in your area. Please help us by using the following speed test.</p><br>
          	          <p><a href="https://wncbroadband.org/blog/speedtest-best-practices/" target="_blank" style="color: black; text-decoration: underline">click here for information on how to get a more accurate speed test</a></p><br>
						<div id="speedtestArea">
							<?php include "speedtest_forinclude.php"?>
						</div>          	
          	            <script type="text/javascript">
             			function getResults(down, up){
                 			//this function is called from the included speedtest php file once the test ends in order to pass the data up.
                 			console.log("getResults function was successfully called."); 
                	 		console.log("download speed received by parent from test: " + down);
     	            		console.log("upload speed received by parent from test: " + up);
     	            		changeGraphic(down);  //this changes the green checkmark / red x graphic
     	            		document.getElementById("downtextbox").value=down;
     	            		document.getElementById("uptextbox").value=up;
     	            		document.getElementById("downtextbox").onchange();     	            		
     	            		document.getElementById("uptextbox").onchange();
             			}
            	    </script>            
            		<br><br>
            		<h4>We recommend taking the test more than once. The best results from your speed tests will be saved.</h4><br>
                    <h5 class="text-center">Your Best Results from the Speed Test:</h5>
           			<p class="text-center lead">Download Speed <input id="downtextbox" readonly type="text" class="js-input" name="SPEEDTEST__libre__download" class="text" maxlength="5" size="5"> Mbps</p>
             		<p class="text-center lead">Upload Speed <input id="uptextbox" readonly type="text" class="js-input" name="SPEEDTEST__libre__upload" class="text" maxlength="5" size="5"> Mbps</p>         			
          			<br><br>
           			<h4>Based on the results of the speed test, your download speed allows you the following capabilities of various applications:</h4><br>
            		<div class="slidecontainer">
              			<p class="text-center lead">Download Speed: <span id="demo"></span><span id="plus"></span> Mbps</p>
              			<table class="table table-bordered table-sm">
                			<thead class="thead-light">
                  				<tr>
                    			<th scope="col">Check email</th>
                    			<th scope="col">Stream HD content</th>
                    			<th scope="col">Stream 4K content and play competitive online games</th>
                    			<th scope="col">Stream 4K content, play online games, and download very large files</th>
                  				</tr>
                			</thead>
                			<tbody>
                  				<tr>
                                <td style="text-align: center;"><img id="img1" src="../img/x.png" width="50px" height="50px"></td>
                                <td style="text-align: center;"><img id="img2" src="../img/x.png" width="50px" height="50px"></td>
                                <td style="text-align: center;"><img id="img3" src="../img/x.png" width="50px" height="50px"></td>
                                <td style="text-align: center;"><img id="img4" src="../img/x.png" width="50px" height="50px"></td>
                  				</tr>
                			</tbody>
              			</table>
              			<small>A green check mark means your speed is fast enough for the associated capabilities</small>             			
            		</div>
            		<br>
            		<br><div class="q-break"></div><br>
            		<p class="lead">Thank you for taking the speed test. Once you are finished, please click "Submit" below to submit your responses.</p>
            		<input required name="submit" id="submit" class="btn btn-primary mt-auto mb-5" type="submit" value="Submit">      
              		</form>
				</div>
        		</div>
      		<div class="my-auto showcase-text offset-lg-2 survey-bg col-lg-8">
      		</div>
		</div>  
	</section>
  
    <!-- Footer -->
	<div class="separate"></div>
	<?php include("http://www.wncbroadband.org/includes/footer.php");?>


    <script>
    //this script updates the red X's into green checks based on download speed parameter
		function changeGraphic(downloadSpeed){
	    	var output = document.getElementById("demo");			
	    	output.innerHTML = downloadSpeed;
			if(downloadSpeed >= 1){
            	document.getElementById("img1").src = "../../img/check.png";
          	} else {
            	document.getElementById("img1").src = "../../img/x.png";
          	}
          	if(downloadSpeed >=15){
            	document.getElementById("img2").src = "../../img/check.png";
          	} else {
            	document.getElementById("img2").src = "../../img/x.png";
          	}
          	if(downloadSpeed >=40){
            	document.getElementById("img3").src = "../../img/check.png";
          	} else {
            	document.getElementById("img3").src = "../../img/x.png";
          	}
          	if(downloadSpeed >=200){
            	document.getElementById("img4").src = "../../img/check.png";
            	document.getElementById("plus").innerHTML = "+";
          	} else {
            	document.getElementById("img4").src = "../../img/x.png";
            	document.getElementById("plus").innerHTML = "";
          	}
		}
	</script>
</body>
</html>


