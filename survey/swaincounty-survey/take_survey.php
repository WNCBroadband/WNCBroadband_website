<?
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
include('../../db.php');
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
 	<title>WNC Broadband Project | Survey</title>
    <!-- Bootstrap core CSS -->
	<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQuery -->
	<script src="/biltmorelake/js/jquery.min.js"></script> 
    <!-- Bootstrap core CSS -->
	<link href="../../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!--Site Stylesheet-->
	<link href="../../css/style.css" rel="stylesheet" type="text/css">	
	<script src="../../vendor/jquery/jquery.slim.min.js"></script>
	<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>	
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
        //  Sends the updated results on every change
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
                	if( response_id < 0) { // if we have not already found the response_id
                    	var response_variable = this.responseText.match(/response_id=\d+/);
                    	//console.log(response_variable);        
                    	if(response_variable){
                        	response_num = response_variable[0].match(/\d+/);
                        	//console.log(response_num);
                        	response_id = response_num;
                    	}
                	}
            	}
          };
          xhttp.open("GET", "../save_question.php?uuid="+uuid+"&name="+this.name+"&value="+this.value+"&survey_id=10&type="+this.type,true);
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
    <!-- main navigation -->
	<?php include("http://wncbroadband.org/includes/nav_main_core.php");?>
	<section class="header bg-broad pt-5">  
  		<div class="container pt-5">
  			<div class="row">
  				<div class="col-lg-7">
  					<h1>Swain County</h1>
  				</div>
  			</div>
  		</div>
	</section>			
   	<section class="p-3"></section>
 	<section class="showcase">
    	<div id="survey-bg" class="container-fluid p-5 row">
        	<div class="mx-auto col-lg-8">
        	</div>
     	<div class="mx-auto col-lg-8">
         	<h2>Please answer the following questions. It should only take about 5 minutes.</h2><br>
        	<div class="form-group">
          		<form id="fullsurvey" class="form" method="POST" action="save_survey.php"> 
          			<SCRIPT>
          				document.write('<INPUT TYPE="hidden" name="uuid" value="'+uuid+'">');
          			</SCRIPT>
					<script>
 						var user_in_address;
  						var lat_coord=0;
  						var lng_coord=0;
						//////////////////////////////////////
  						function update_geo(){
    						if( document.getElementById("street_address").value ){
        						user_in_address = "" + document.getElementById("street_address").value + ", " + document.getElementById("city_address").value + " "+ document.getElementById("state_address").value +  " " + document.getElementById("zip_address").value;
        						console.log(user_in_address);
						        document.getElementById("fullsurvey").action="save_survey.php?geoip_latitude="+lat_coord+"&geoip_longitude="+lng_coord+"&user_address="+user_in_address+"&response_id="+response_id;
    						}
  						}
						//////////////////////////////////////
					</script>
                    <?                    
                    //Populate Questions From Database
                    echo '<INPUT type="hidden" name="survey_id" value="10">';                    
                    $sql = "
                    SELECT q.display_html as 'html' 
                    FROM Question q, Survey s, Survey_Questions sq
                    WHERE s.id = 10
                      AND sq.survey_id = s.id
                      AND sq.question_id = q.id
                    ORDER BY sq.display_order asc
                    ";                    
                    $result = $conn->query($sql);
                    if ($conn->error) {
                        echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
                    }
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                        echo($row['html']);
                        }
                    }else{
                        echo("No Questions Found");
                    }
                    $conn->close();
                    ?>
					<br>
          			<br>
          			<div class="q-break"></div><br>
            		<h4>10&#41; We are constructing a map of broadband speeds in the neighborhood. Would you be willing to provide your address for us to display the speed of your internet service on the map? (We will not sell any data).</h4><br>
                    <script>
                    	function getLocation() {
                      		if (navigator.geolocation) {
                        		navigator.geolocation.getCurrentPosition(showPosition);
                      		}
                      	document.getElementById('hidden_address_block').style.display='block';
                    	}
                    	function showPosition(position) {
                      		document.getElementById('geoip_latitude').value = position.coords.latitude;
                      		document.getElementById('geoip_longitude').value = position.coords.longitude;
                              ///////////////////////////////////////
                              lat_coord = position.coords.latitude;
                              lng_coord = position.coords.longitude;
                            
                              update_geo();
                              ///////////////////////////////////////
                    		var xhttp = new XMLHttpRequest();
                      		xhttp.onreadystatechange = function() {
                        		if (this.readyState == 4 && this.status == 200) {
                          			console.log(this.responseText);
                        		}
                      		};
                     		 xhttp.open("GET", "../save_question.php?uuid="+uuid+"&survey_id=10&geoip_latitude="+position.coords.latitude+"&geoip_longitude="+position.coords.longitude,true);
                      		xhttp.send();
                    	}
                    </script>
                	<input required name="permission" type="radio" onclick="getLocation()">&nbsp;&nbsp;Yes
            		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              		<input required name="permission" type="radio">&nbsp;&nbsp;No
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
            		<h4>11&#41; There are major issues in broadband delivery concerning where broadband is available and what the actual speeds are delivered by providers. We are working on ways to determine the speeds in your area. Please help us by using the following speed test</h4><br>
            		<p><a href="https://wncbroadband.org/blog/speedtest-best-practices/" target="_blank" style="color: black; text-decoration: underline">click here for information on how to get a more accurate speed test</a></p><br>
					
					<div id="speedtestArea">
						<?php include "speedtest.php"?>
					</div>
                    <script type="text/javascript">
             			function getResults(down, up){
                 			//this function is called from the speedtest iframe once the test ends in order to pass the data up.
                 			console.log("getResults function was successfully called."); 
                	 		console.log("download speed sent: " + down);
     	            		console.log("upload speed sent: " + up);
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
                        <p class="text-center lead">Your Download Speed: <span id="demo">0</span><span id="plus"></span> Mbps</p>
                        <table class="table table-bordered table-sm">
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">Check email, Basic web browsing</th>
                              <th scope="col">Stream HD content, Video conferencing, Online gaming</th>
                              <th scope="col">Stream 4K content, Multiple users/devices</th>
                              <th scope="col">Large file sharing</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="text-align: center;"><img id="img1" src="../../img/x.png" width="50px" height="50px"></td>
                              <td style="text-align: center;"><img id="img2" src="../../img/x.png" width="50px" height="50px"></td>
                              <td style="text-align: center;"><img id="img3" src="../../img/x.png" width="50px" height="50px"></td>
                              <td style="text-align: center;"><img id="img4" src="../../img/x.png" width="50px" height="50px"></td>
                            </tr>
                          </tbody>
                        </table>
                        <small>A green check mark means your speed is fast enough for the associated capabilities</small>
                     </div>
          			<br><br>
          			<div class="q-break"></div><br>
            		<h4>If you have any additional comments, or if you are interested in being contacted about this projects developments and would like to leave your name and address, please do so below.</h4><br>
            		<textarea id="comments" name="comments" cols="70" rows="6"></textarea>
          			<br><br>
          			<div class="q-break"></div><br>
            		<h4>Thank you for participating in this survey. Once you are finished, please click "Submit" below to submit your responses.</h4><br>
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
  	
	<script src="../speedtestslider.js"></script>  
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


