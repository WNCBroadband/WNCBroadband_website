<?
header("Content-Type: application/json; charset=UTF-8");


#$servername = "138.68.228.126";
#$username = "drawertl_westngn";
#$password = "dbpass_adh4enal";
#$dbname = "drawertl_westngn";
#
#$conn = new mysqli($servername, $username, $password, $dbname);

include('../../../db.php');


if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
    exit(0);
}
$success=false;

$sql = "SELECT 
    count(d.id), r.id,
    COALESCE(max(d.`download_speed`),max(rsd.`download_speed`),'undefined') as `download_speed`, 
    COALESCE(max(d.`upload_speed`),max(rsd.`upload_speed`),'undefined') as `upload_speed`, 
    r.geoip_latitude as `latitude`,
    r.geoip_longitude as `longitude`
FROM `Responses` r
LEFT JOIN `Responses_speed_data` rsd
       ON rsd.response_id = r.id
LEFT JOIN `MLABS_speed_data` d 
       ON d.`ip_address` = r.`ip_address`
WHERE r.`include_on_map` = 1
  AND r.`geoip_latitude` IS NOT NULL 
  AND r.`geoip_latitude`  != 0
  AND r.`geoip_longitude` IS NOT NULL
  AND r.`geoip_longitude` != 0
GROUP BY r.id";

$stmt = $conn->prepare($sql);
if(!$stmt){
    echo "console.log('survey_data.php: DB Prepare Error: ".str_replace('\'', '\\\'', $conn->error)."');";
    echo 'console.log("sql: '.$sql.'");';
}else{
    $stmt->execute();
    if ($conn->error) {
        echo "console.log('survey_data.php: DB Execute Error: ".str_replace('\'', '\\\'', $conn->error)."');";
    }else{
        $result = $stmt->get_result();
        $success=true;
    }
}





if ($success && $result->num_rows == 0) {
    echo("console.log('survey_data.php: No Data found');");
}else{
    echo("console.log('survey_data.php: ".$result->num_rows." records found');");
}
// need to output the empty set anyway
echo 'survey_result_points = {
"type": "FeatureCollection",
"features": [ 
';
// output data of each row
if ($success && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '{ "type": "Feature", ';
        echo '"properties": { "download_speed":'.$row['download_speed'].', "upload_speed":'.$row['upload_speed'].'},';
        echo '"geometry": { "type": "Point", "coordinates": [ '.$row["longitude"].', '.$row['latitude'].' ] } },'."\n";
    }
}
echo ']
}
';
$conn->close();

