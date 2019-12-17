<?
header("Content-Type: application/json; charset=UTF-8");


$servername = "138.68.228.126";
$username = "drawertl_westngn";
$password = "dbpass_adh4enal";
$dbname = "drawertl_westngn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
    exit(0);
}

$sql = "SELECT download_speed, upload_speed, latitude, longitude FROM MLABS_speed_data";
$result = $conn->query($sql);

if ($conn->error) {
    echo("Query failed: ".$conn->error);
    exit(0);
}


echo 'survey_result_points = {
"type": "FeatureCollection",
"features": [ 
';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '{ "type": "Feature", ';
	echo '"properties": { "download_speed":'.$row['download_speed'].', "upload_speed":'.$row['upload_speed'].'},';
	echo '"geometry": { "type": "Point", "coordinates": [ '.$row["longitude"].', '.$row['latitude'].' ] } },'."\n";
    }
}else{
    echo("No Data found");
    exit(0);
}
$conn->close();

echo ']
}
';
