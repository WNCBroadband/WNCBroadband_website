<!DOCTYPE html>
<HTML>
<HEAD><TITLE>Geocode</TITLE>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>

</HEAD>
<BODY>

<?php 

include('./db.php');

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
    $sql = "select id, geoip_latitude, geoip_longitude, home_address_street, home_address_city, home_address_state, home_address_zip, geocoding_performed from Responses";
    $stmt = $conn->prepare($sql);
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
                    $row['geoip_latitude'].' '.$row['geoip_longitude'],
                    implode(' ',array($row['home_address_street'],
                                        $row['home_adress_city'],
                                        $row['home_address_state'],
                                        $row['home_address_zip'])
                                        ),
                    $row['geocoding_performed'],
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

if(isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['id']) ){
    update_response_geoip();
}


$resps = select_response();
?>
<TABLE BORDER=1 width="100%">
<?
foreach($resps as $r){
    $id = $r[0];
    $lat_long = $r[1];
    $addr = $r[2];
    $geocode_fg = $r[3];
    if(strlen(trim($lag_long)) > 0 || strlen(trim($addr)) > 0){
        echo "<TR><TD>". implode('</TD><TD>', array($lat_long, $addr)) . '</TD>';
        echo '<TD><form action="" method="post">
            <input type="hidden" name="address" value="'.$addr.'">
            <input type="hidden" name="id" value="'.$id.'">
            <input type="submit" value="Lookup"></form>';
        echo '</TD></TR>'."\n";
    }
}
?>
</TABLE>



<?
if(isset($_POST['address'])){
    $data_arr =  geocode($_POST['address']);
    if($data_arr){
         
        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
        $formatted_address = $data_arr[2];

        echo "<BR><BR><HR>";
        echo "<CENTER><H3>Coordinates found:<BR><BR>";
        echo $latitude.", ".$longitude;
        echo "</H3>";
        echo '<form action="" method="post">
            <input type="hidden" name="latitude" value="'.$latitude.'">
            <input type="hidden" name="longitude" value="'.$longitude.'">
            <input type="hidden" name="id" value="'.$_POST['id'].'">
            <input type="submit" value="Update Record in Database"></form>';

        echo "</CENTER><BR><BR><HR>";

                     
?>
    <!-- google map will be shown here -->
    <div id="map"></div>
    <script>
        // Initialize and add the map
        function initMap() {
          // The location of Uluru
          var uluru = {lat: <? echo $latitude;?>, lng: <? echo $longitude;?>};
          // The map, centered at Uluru
          var map = new google.maps.Map(
              document.getElementById('map'), {zoom: 13, center: uluru});
          // The marker, positioned at Uluru
          var marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlAwxc91arMg6vYn1pMyzt_an5E4EAD6g&callback=initMap">
    </script>
<?
    }
}
?>


