<!doctype html>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<?php
//==========================================================
//Goals of this script
//==========================================================
//1. Read in response_number and address from save_speedtest
//2. Connect to the appropriate SQL database
//3. Geocode the address to new_latlng
//4. Inject new_latlng into geoip field for response_number

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
            echo "<script>console.log(\"!geocoded lat to \" +" . $lati . ");</script>";
            echo "<script>console.log(\"!geocoded long to \" +" . $longi . ");</script>";
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

function update_response_geoip($latitude, $longitude, $id){
    global $conn;
    //$_GET['geoip_latitude'], $_GET['geoip_longitude']
    $sql = "UPDATE Responses set geoip_latitude=?, geoip_longitude=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $latitude, $longitude, $id);
    $stmt->execute();
    if($conn->error){
        echo "DB Error inserting response: ".$conn->error."\n";
    }else{
        echo "updated response: geoip\n";
    }
}


?>

    <script type="text/javascript">
        console.log("Hello from JS in geocode_s0.php");
        console.log(<?= json_encode($geo_address); ?>);
        console.log(<?= json_encode($response_number); ?>);


    </script>
</body>
</html>

