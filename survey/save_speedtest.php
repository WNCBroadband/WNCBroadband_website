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
$saved_geoip_latitude = $_GET['geoip_latitude'];
$saved_geoip_longitude = $_GET['geoip_longitude'];
$saved_user_address = $_GET['user_address'];

<!DOCTYPE html>
<HTML>
<HEAD><TITLE>Geocode</TITLE>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
       TD {
         overflow: hidden;
       }
    </style>

</HEAD>
<BODY>

<?php 

include('../db.php');

// First, check which survry
if(!isset($_GET['survey_id'])){

    echo '<FORM METHOD="GET" ACTION="">
    Edit Survey: <SELECT name="survey_id">';

    $sql = "SELECT id,name FROM `Survey`";
    $result = $conn->query($sql);
    if ($conn->error) {
        echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    }
    echo '<OPTION value="0"> -- Non-survey speed tests -- </OPTION>';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        echo('<OPTION VALUE="'.$row['id'].'">'.$row['name'].'</OPTION>');
        }
    }
    $conn->close();
    echo '</SELECT><INPUT type="submit" value="Go"></FORM>';
    exit(0);
}





//=============================================================================
// function to geocode address, it will return false if unable to geocode address
//https://www.codeofaninja.com/2014/06/google-maps-geocoding-example-php.html
function geocode($address){
 
    // url encode the address
    $address = urlencode($address);
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyBlAwxc91arMg6vYn1pMyzt_an5E4EAD6g";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }else{
        echo "<strong>ERROR: {$resp['status']}: {$resp['error_message']}</strong>";
        return false;
    }
}


function select_response(){
    global $conn;
    $sql = "select id, date_taken, geoip_latitude, geoip_longitude, home_address_street, home_address_city, home_address_state, home_address_zip, geocoding_performed, include_on_map, ip_address from Responses where survey_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$_GET['survey_id']);
    if(!$stmt){ echo "DB Error select response: ".$conn->error."\n"; exit(0);}
    $stmt->execute();
    if($conn->error){
        echo "DB Error select response: ".$conn->error."\n";
    }
    $ret = array();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            array_push( $ret, 
                array(
                    $row['id'],
                    $row['date_taken'],
                    $row['geoip_latitude'].' '.$row['geoip_longitude'],
                    implode(' ',array($row['home_address_street'],
                                        $row['home_adress_city'],
                                        $row['home_address_state'],
                                        $row['home_address_zip'])
                                        ),
                    $row['geocoding_performed'],
                    $row['include_on_map'],
                    $row['geoip_latitude'],
                    $row['geoip_longitude'],
                    $row['ip_address'],
                )
            );
        }
    }
    return $ret;
}

function update_response_geoip(){
    global $conn;
    //$_GET['geoip_latitude'], $_GET['geoip_longitude']
    $sql = "UPDATE Responses set geoip_latitude=?, geoip_longitude=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $_POST['latitude'], $_POST['longitude'],$_POST['id']);
    $stmt->execute();
    if($conn->error){
        echo "DB Error inserting response: ".$conn->error."\n";
    }else{
        echo "updated response: geoip\n";
    }
}

function update_include_on_map(){
    global $conn;
    //$_GET['geoip_latitude'], $_GET['geoip_longitude']
    $sql = "UPDATE Responses set include_on_map=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $_POST['include_on_map'], $_POST['id']);
    $stmt->execute();
    if($conn->error){
        echo "DB Error inserting response: ".$conn->error."\n";
    }else{
        echo "updated response: include_on_map\n";
    }
}

function select_speed_tests($ip){
    global $conn;
    $sql = "select ip_address, date_taken, download_speed, upload_speed from MLABS_speed_data where ip_address=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$ip);
    if(!$stmt){ echo "DB Error select response: ".$conn->error."\n"; exit(0);}
    $stmt->execute();
    if($conn->error){
        echo "DB Error select response: ".$conn->error."\n";
    }
    $ret = array();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            array_push( $ret,  
                array(
                    $row['ip_address'],
                    $row['date_taken'],
                    $row['download_speed'],
                    $row['upload_speed'],
                )
            );
        }
    }
    return $ret;
}

//==================================================================================
// check and update db records
if(isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['id']) ){
    update_response_geoip();
}
if(isset($_POST['include_on_map']) && isset($_POST['id'])){
    update_include_on_map();
}
//==================================================================================
function print_speed_tests($ip){
    //if(isset($_GET['ip_address'])){
    $speed_tests = select_speed_tests($ip);
    ?>
    <?
}


//==================================================================================
$resps = select_response();

if(isset($_POST['id']) && isset($_POST['address'])){
    $rec = NULL;
    foreach($resps as $r){
        $id = $r[0];
        $lat_long = $r[2];
        if($id == $_POST['id']){
            $rec = array( $r[6], $r[7] );
            break;
        }
    }


    // perform the geocoding lookup
    $data_arr =  geocode($_POST['address']);
    if($data_arr){
         
        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
        $formatted_address = $data_arr[2];

?>
<?
    }
}

?>


<script>
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
