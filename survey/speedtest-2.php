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

  <title>WNC Broadband Project | Speed Test</title>

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
//    Apply a Unique identifier for this page
    function uuidv4() {
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
      });
    }
    var uuid = uuidv4();

    var checkbox_limit = 3;
//    Sends the updated results on every change
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
      xhttp.open("GET", "save_question.php?uuid="+uuid+"&name="+this.name+"&value="+this.value+"&survey_id=0&type="+this.type,true);
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


   <section class="header bg-broad pt-5">  
  <div class="container pt-5">
  <div class="row">
  <div class="col-lg-7">
  <h1>Speed Test</h1>
  </div>
  </div>
  </div>
</section>

  <section class="showcase">
    <div id="survey-bg" class="container-fluid p-5 row">
        <div class="mx-auto col-lg-8">
        </div>
      <div class="mx-auto col-lg-8">
        <div class="form-group">
          <form id="fullsurvey" class="form" method="POST" action="save_speedtest.php">    
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
  document.getElementById('geoip_latitude').value = position.coords.latitude;
  document.getElementById('geoip_longitude').value = position.coords.longitude;

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open("GET", "save_question.php?uuid="+uuid+"&survey_id=0&geoip_latitude="+position.coords.latitude+"&geoip_longitude="+position.coords.longitude,true);
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
          <br>

    <div class="q-break"></div><br>
      <p class="lead">There are major issues in broadband delivery concerning where broadband is available and what the actual speeds are delivered by providers. We are working on ways to determine the speeds in your area. <b>Please help us by using the M-Labs speed test and reporting your results using the sliders below.</b></p><br>
      <iframe frameborder="0" height="550px" src="https://speed.measurementlab.net/#/" width="100%"></iframe>
      <p class="small text-center">If the speed test does not show up, click <a href="https://speed.measurementlab.net/#/" target="_blank"> here </a> to open it in a new tab.</p>
      <br><br>
      <h4>Please Input your Download Speed from the M-Labs Speed Test:</h4>
      <div class="slidecontainer">
        <input id="downslider" name="SPEEDTEST__self-reported__download" type="range" class="js-range-slider slider" min="1" max="200" step="0.1" value="1" data-rangeslider>
        <p class="text-center lead">Download Speed <input id="downtextbox" type="text" class="js-input" name="SPEEDTEST__self-reported__download" id="downloadspeedval-biltmorelakes" class="text" maxlength="5" size="5"> Mbps</p>
      </div>
      <h4>Please Input your Upload Speed from the M-Labs Speed Test:</h4>
      <div class="slidecontainer">
        <input id="upslider"  name="SPEEDTEST__self-reported__upload" type="range" class="js-range-slider slider" min="1" max="200" step="0.1" value="1" data-rangeslider>
        <p class="text-center lead">Upload Speed <input id="uptextbox" type="text" class="js-input" name="SPEEDTEST__self-reported__upload" id="uploadspeedval-biltmorelakes" class="text" maxlength="5" size="5"> Mbps</p>
      </div>
      <br><br>
      <h4>From the results of the M-Labs test, explore the capabilities of your download speed with the speeds needed for various applications using the slider below.</h4><br>
        <div class="slidecontainer">
          <input type="range" min="1" max="200" value="1" class="slider" id="myRange">
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
        </div>
        <br>
        <br><div class="q-break"></div><br>
        <p class="lead">Thank you for taking the speed test. Once you are finished, please click "Submit" below to submit your responses.</p>
        <input required name="submit" id="submit" class="btn btn-primary mt-auto mb-5" type="submit" value="Submit" 
        action="save_speedtest.php?geoip_latitude<?php echo $var_value ?>&geoip_longitude<?php echo $var_value ?>">
      
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
    document.getElementById("img1").src = "../img/check.png";
  } else {
    document.getElementById("img1").src = "img/x.png";
  }
  if(this.value >=15){
    document.getElementById("img2").src = "../img/check.png";
  } else {
    document.getElementById("img2").src = "../img/x.png";
  }
  if(this.value >=40){
    document.getElementById("img3").src = "../img/check.png";
  } else {
    document.getElementById("img3").src = "../img/x.png";
  }
  if(this.value >=200){
    document.getElementById("img4").src = "../img/check.png";
    document.getElementById("plus").innerHTML = "+";
  } else {
    document.getElementById("img4").src = "../img/x.png";
    document.getElementById("plus").innerHTML = "";
  }
}
</script>
<script src="../vendor/jquery/jquery.slim.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="speedtestslider.js"></script>

</body>
</html>


