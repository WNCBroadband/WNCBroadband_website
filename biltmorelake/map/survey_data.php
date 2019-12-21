<?
header("Content-Type: application/json; charset=UTF-8");


#$servername = "138.68.228.126";
#$username = "drawertl_westngn";
#$password = "dbpass_adh4enal";
#$dbname = "drawertl_westngn";
#
#$conn = new mysqli($servername, $username, $password, $dbname);

include('../../db.php');


if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
    exit(0);
}
$success=false;

if(isset($_GET['survey_id']) && !empty($_GET['survey_id'])){
    // Show response geo locations, 
#    $sql = "SELECT 
#        count(d.id), r.id,
#        IFNULL(max(d.`download_speed`),'undefined') as `download_speed`, 
#        IFNULL(max(d.`upload_speed`),'undefined') as `upload_speed`, 
#        r.geoip_latitude as `latitude`,
#        r.geoip_longitude as `longitude`
#    FROM `Responses` r
#    LEFT JOIN `MLABS_speed_data` d 
#           ON d.`ip_address` = r.`ip_address`
#           AND DATEDIFF(r.`date_taken`, d.`date_taken`) < 7
#    WHERE r.`survey_id` = ?
#      AND r.`geoip_latitude` IS NOT NULL 
#      AND r.`geoip_latitude`  != 0
#      AND r.`geoip_longitude` IS NOT NULL
#      AND r.`geoip_longitude` != 0
#    GROUP BY r.id";
    // The below version doesn't have the date requirement
    $sql = "SELECT 
        count(d.id), r.id,
        IFNULL(max(d.`download_speed`),'undefined') as `download_speed`, 
        IFNULL(max(d.`upload_speed`),'undefined') as `upload_speed`, 
        r.geoip_latitude as `latitude`,
        r.geoip_longitude as `longitude`
    FROM `Responses` r
    LEFT JOIN `MLABS_speed_data` d 
           ON d.`ip_address` = r.`ip_address`
    WHERE r.`survey_id` = ?
      AND r.`geoip_latitude` IS NOT NULL 
      AND r.`geoip_latitude`  != 0
      AND r.`geoip_longitude` IS NOT NULL
      AND r.`geoip_longitude` != 0
    GROUP BY r.id";

#SELECT count(d.id), r.id, max(d.`download_speed`), max(d.`upload_speed`), r.geoip_latitude as `latitude`, r.geoip_longitude as `longitude` FROM `Responses` r LEFT JOIN `MLABS_speed_data` d ON d.`ip_address` = r.`ip_address` WHERE r.`survey_id` = 1 AND r.`geoip_latitude` IS NOT NULL AND r.`geoip_latitude` != 0 AND r.`geoip_longitude` IS NOT NULL AND r.`geoip_longitude` != 0 GROUP BY r.id


    $stmt = $conn->prepare($sql);
    if(!$stmt){
        echo "console.log('survey_data.php: DB Prepare Error: ".str_replace('\'', '\\\'', $conn->error)."');";
        echo 'console.log("sql: '.$sql.'");';
    }else{
        $stmt->bind_param("i",$_GET['survey_id']);
        $stmt->execute();
        if ($conn->error) {
            echo "console.log('survey_data.php: DB Execute Error: ".str_replace('\'', '\\\'', $conn->error)."');";
        }else{
            $result = $stmt->get_result();
            $success=true;
        }
    }

}else{
    // Show all, using mlabs/network geo location
    $sql = "SELECT download_speed, upload_speed, latitude, longitude FROM MLABS_speed_data";
    $result = $conn->query($sql);
    if ($conn->error) {
        echo "console.log('survey_data.php: DB Error: ".str_replace('\'', '\\\'', $conn->error)."');";
        echo 'console.log("sql: '.$sql.'");';
    }else{
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

