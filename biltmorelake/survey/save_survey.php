<!DOCTYPE html>
<html lang="en">
<!--
<?
include('../../db.php');



function save_survey(){
    global $conn;
    $survey_id = intval($_POST['survey_id']);

    $sql1 = "insert into Responses (survey_id, geoip_latitude, geoip_longitude, home_address_street, home_address_city, home_address_state, home_address_zip, ip_address, comments,uuid) values(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql1);
    if(!$stmt){
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return;
    }
    $stmt->bind_param("isssssssss", $survey_id, $_POST['geoip_latitude'], $_POST['geoip_longitude'], $_POST['street_address'], $_POST['city_address'], $_POST['state_address'], $_POST['zip_address'], $_SERVER['REMOTE_ADDR'], $_POST['comments'],$_POST['uuid']);
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error inserting response: ".$conn->error."<BR>";
        return;
    }
    $response_id = $conn->insert_id;


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
    save_survey();
}

?>
-->
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WestNGN Broadband</title>

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
</head>

<body>

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
            <li><a class="dropdown-item" href="map.html">Biltmore Lake</a></li>
           </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
<section class="header">  
  <div class="container">
        <h1 class="mt-3 mb-5 text-center">Thank you for taking our survey!</h1>
        <p class="lead">Thank you for your participation in this survey.<br><br>
        Learn more about how you can get involved and get further engaged in broadband issues.</p>
        <a class="btn btn-primary mb-5" href="../getinvolved.html">Get Involved! &gt;</a>
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
        <div class="row">
        <p>&copy;2019 WestNGN | All Rights Reserved</p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
