<!DOCTYPE html>
<html lang="en">
<!--
<?
include('../../db.php');



function save_survey_no_uuid(){
    global $conn;
    $survey_id = intval($_POST['survey_id']);

    $sql1 = "insert into Responses (survey_id, geoip_latitude, geoip_longitude, home_address_street, home_address_city, home_address_state, home_address_zip, ip_address, comments) values(?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql1);
    if(!$stmt){
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return NULL;
    }
    $stmt->bind_param("issssssss", $survey_id, $_POST['geoip_latitude'], $_POST['geoip_longitude'], $_POST['street_address'], $_POST['city_address'], $_POST['state_address'], $_POST['zip_address'], $_SERVER['REMOTE_ADDR'], $_POST['comments']);
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return NULL;
    }
    $response_id = $conn->insert_id;
    return $response_id;
}

function save_survey(){
    global $conn;
    $survey_id = intval($_POST['survey_id']);

    $sql1 = "insert into Responses (survey_id, geoip_latitude, geoip_longitude, home_address_street, home_address_city, home_address_state, home_address_zip, ip_address, comments,uuid) values(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql1);
    if(!$stmt){
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return NULL;
    }
    $stmt->bind_param("isssssssss", $survey_id, $_POST['geoip_latitude'], $_POST['geoip_longitude'], $_POST['street_address'], $_POST['city_address'], $_POST['state_address'], $_POST['zip_address'], $_SERVER['REMOTE_ADDR'], $_POST['comments'],$_POST['uuid']);
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return NULL;
    }
    $response_id = $conn->insert_id;
    return $response_id;
}

function save_survey_questions($response_id){
    global $conn;
    $survey_id = intval($_POST['survey_id']);
    $sql2 = "
    SELECT q.id as 'id', q.name as 'name'
    FROM Question q, Survey s, Survey_Questions sq
    WHERE s.id = ?
      AND sq.survey_id = s.id
      AND sq.question_id = q.id
    ORDER BY sq.display_order asc
    ";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i",$survey_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(!empty($_POST[$row['name']])){
                #echo "Inserting into Survey_Questions_Responses: (name=".$row['name'].") ";
                #echo "$survey_id, ".$row['id'].", $response_id, ".$_POST[$row['name']];
                #echo "<BR>";
                $sql3 = "insert into Survey_Questions_Responses (survey_id, question_id, response_id, answer) values(?,?,?,?)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("iiis",$survey_id, $row['id'], $response_id, $_POST[$row['name']]);
                $stmt3->execute();
                if($conn->error){
                    echo "DB Error inserting survey_quesions_response: ".$conn->error."<BR>";
                    return;
                }
            }
        }
    }
}

#print_r($_POST);
if(!empty($_POST['survey_id'])){
    if( isset($_POST['uuid']) && !empty($_POST['uuid']) ){
        $resp_id = save_survey();
    }else{
        $resp_id = save_survey_no_uuid();
    }
    if(!is_null($resp_id)){
        save_survey_questions($resp_id);
    }
}

?>
-->
<head>

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
            <a class="nav-link" href="https://wncbroadband.org/blog/blog">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/archives">Archives</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../101links.html">Resources</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../faq.html">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../contact.html">Contact</a>
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
            <a class="nav-link" href="../../biltmorelake/index.html">Biltmore Lake</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../biltmorelake/aboutBiltmoreLake.html">About Community</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../../biltmorelake/survey.html">Survey</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../biltmorelake/providers.html">Service Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../biltmorelake/communitycontacts.html">Community Contacts</a>
          </li>
           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Biltmore Lake Maps</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="../../biltmorelake/map/map.html">Speed Test Results</a></li>
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
        Learn more about how you can get involved and get further engaged in broadband issues <a href="../../biltmorelake/getinvolved.html"><b>here</b></a>.<br><br>
        You can also take the <a href="../speedtest.php"> Speed Test</a> on our main site and help contribute your speeds to your community map.<br></br>
        <a href="../../biltmorelake/index.html">Return to community homepage</a></p>
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
              <a href="../../101links.html">Resources</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../../faq.html">FAQ</a>
            </li><br>
            <li class="list-inline-item">
              <a href="../../contact.html">Contact</a>
            </li><br>
          </ul>
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
