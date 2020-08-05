<!DOCTYPE html>
<html lang="en">
<!--
<?
/*
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
*/
?>
-->


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
  <script src="https://www.wncbroadband.org/vendor/jquery/jquery.min.js"></script> 
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


	<?php include("http://www.wncbroadband.org/includes/nav_main_survey.php");?>

    <!-- Page Content -->
	<section class="p-3"></section>
	<section class="header">  
  		<div class="custom-container">
        	<h1 class="mt-3 mb-5 text-center">Thank you for taking our survey!</h1>
        	<p class="lead">Thank you for your participation in this survey. <br>
        	Learn more about how you can get involved and get further engaged in broadband issues <a href="https://wncbroadband.org/blog/advocacy/"><b>here</b></a>.<br><br>
        	<a href="http://www.wncbroadband.org/blog">Return to WNC Broadband Project homepage</a></p>
  		</div>
	</section>
	<div class="separate"></div>
	<?php include("http://www.wncbroadband.org/includes/footer.php");?>
</body>
</html>
