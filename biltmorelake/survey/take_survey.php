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

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WestNGN | Survey</title>

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
	
	<script>
//		Apply a Unique identifier for this page
		function uuidv4() {
		  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		  });
		}
		var uuid = uuidv4();

    var checkbox_limit = 3;
//		Sends the updated results on every change
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
			}
		  };
		  xhttp.open("GET", "save_question.php?uuid="+uuid+"&name="+this.name+"&value="+this.value+"&survey_id=1&type="+this.type,true);
		  xhttp.send();
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dblue fixed-top stroke">
    <div class="container">
      <a class="navbar-brand" href="../index.html">
        <img src="../img/West_NGN_logo.png" width="100" height="50" alt="WestNGN Logo Image and Link">
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
              <li><a class="dropdown-item" href="../aboutWestNGN.html">WestNGN</a></li>
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
            <li><a class="dropdown-item" href="../map.html">Biltmore Lake</a></li>
           </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="p-5"></section>
  <section class="showcase">
    <div id="survey-bg" class="container-fluid p-5 row">
        <div class="mx-auto col-lg-8">
        </div>
      <div class="mx-auto col-lg-8">
          <h2>Please answer the following 10 questions. It should only take about 5 minutes.</h2><br>
        <div class="form-group">
          <form id="fullsurvey" class="form" method="POST" action="save_survey.php"> 
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

echo '<INPUT type="hidden" name="survey_id" value="1">';


$sql = "
SELECT q.display_html as 'html' 
FROM Question q, Survey s, Survey_Questions sq
WHERE s.id = 1
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
    echo("No Quesions Found");
}
$conn->close();
?>
<br>
          <br><div class="q-break"></div><br>
            <h4>8&#41; We are constructing a map of broadband speeds in the neighborhood. Would you be willing to provide your address for us to display the speed of your internet service on the map? (We will not sell any data).</h4><br>
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

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open("GET", "save_question.php?uuid="+uuid+"&survey_id=1&geoip_latitude="+position.coords.latitude+"&geoip_longitude="+position.coords.longitude,true);
  xhttp.send();

}
</script>
                <input required name="permission" type="radio" onclick="getLocation()">&nbsp;&nbsp;Yes
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input required name="permission" type="radio">&nbsp;&nbsp;No
<input type=hidden id="geoip_latitude" name="geoip_latitude" value="">
<input type=hidden id="geoip_longitude" name="geoip_longitude" value="">
	<DIV id="hidden_address_block" style="display:none">
		Street Address <INPUT class="form-control" name="street_address" type="text"><BR>
		City <INPUT class="form-control" name="city_address" type="text"><BR>
		State <INPUT class="form-control" name="state_address" type="text"><BR>
		Zip Code<INPUT class="form-control" name="zip_address" type="text"><BR>
	</DIV>
          <br>
          <br><div class="q-break"></div><br>
            <h4>9&#41; There are major issues in broadband delivery concerning where broadband is available and what the actual speeds are delivered by providers. Please use the M-Labs Speed Test below to test your speed.</h4><br>
            <iframe frameborder="0" height="500" src="https://speed.measurementlab.net/#/" width="100%"></iframe>
            <br><br>
            <h4>From the results of the M-Labs test, compare the capabilities of your download speed with other speeds using the range slider below.</h4><br>
            <div class="slidecontainer">
              <input type="range" min="1" max="100" value="1" class="slider" id="myRange">
                <p class="text-center lead">Download Speed: <span id="demo"></span></p>
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
              </div>
          <br>
          <br><div class="q-break"></div><br>
            <h4>10&#41; If you have any additional comments, or if you are interested in being contacted about this projects developments and would like to leave your name and address, please do so below.</h4><br>
            <textarea id="comments" name="comments" cols="70" rows="6"></textarea>
          <br>
          <br><div class="q-break"></div><br>
            <h4>Thank you for participating in this survey. Once you are finished, please click "Submit" below to submit your responses.</h4><br>
              <input required name="submit" id="submit" class="btn btn-primary mt-auto mb-5" type="submit">
      
          </form>
          </div>
        </div>
      <div class="my-auto showcase-text offset-lg-2 survey-bg col-lg-8">
      </div>
    </div>  
  </section>
  
    <!-- Footer -->
  <div class="separate"></div>

<footer class="footer bg-dblue text-white pt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6 text-right">
          <ul>
            <li class="list-inline-item">
              <a href="../index.html">Home</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../contact.html">Contact</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../map.html">View Maps</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../../index.html">Change Community</a>
            </li><br>
          </ul>
        </div>
        <div class="col-12 text-center">
        <p>&copy; 2019 WestNGN | <a href="../privacypolicy.html"> Privacy Policy</a></p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Script for only allowing two check boxes for Question 6 -->
  <script>
   /*
   //This was integrated with the  onchange function defined above.
    var limit = 3;
  $('input.limited-checkbox').on('change', function(evt) {
     if($(".limited-checkbox:checked").length >= limit) {
       this.checked = false;
       return false;
     }
  });
  */
  </script>
  <script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;

  if(this.value >= 1){
    document.getElementById("img1").src = "../img/check.png"
  } else {
    document.getElementById("img1").src = "../img/x.png"
  }
  if(this.value >=15){
    document.getElementById("img2").src = "../img/check.png"
  } else {
    document.getElementById("img2").src = "../img/x.png"
  }
  if(this.value >=40){
    document.getElementById("img3").src = "../img/check.png"
  } else {
    document.getElementById("img3").src = "../img/x.png"
  }
  if(this.value >=100){
    document.getElementById("img4").src = "../img/check.png"
  } else {
    document.getElementById("img4").src = "../img/x.png"
  }
}
</script>
<script src="../vendor/jquery/jquery.slim.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>


