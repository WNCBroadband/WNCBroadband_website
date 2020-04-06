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
<TABLE BORDER=1>
<TR><TH>IP Address</TH><TH>Date</TH><TH>Download Speed</TH><TH>Upload Speed</TH></TR>
    <?
    foreach($speed_tests as $s){
        echo '<TR><TD>'.implode('</TD><TD>', $s)."</TD></TR>";
    }
    ?>
    </TABLE><BR>
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

        echo "<BR><BR><HR><CENTER>";
        echo "<H3 style=\"color:red\">Coordinates of Address:<BR>";
        echo $latitude.", ".$longitude;
        echo "</H3>";
        if(isset($rec) && isset($rec[0]) && isset($rec[1])){
            echo "<H3 style=\"color:blue\">Coordinates in database:<BR>";
            echo $rec[0].", ".$rec[1];
            echo "</H3>";
        }else{
            echo "<H3 style=\"color:blue\">No coordinates in database.<BR>";
        }
        echo '<form action="" method="post">
            <input type="hidden" name="latitude" value="'.$latitude.'">
            <input type="hidden" name="longitude" value="'.$longitude.'">
            <input type="hidden" name="id" value="'.$_POST['id'].'">
            <input type="submit" value="Update Location of Record"></form>';

        echo "</CENTER><BR><BR><HR>";

                     
?>
    <!-- google map will be shown here -->
    <div id="map"></div>
    <script>
        // Initialize and add the map
        function initMap() {
          // The location of Uluru
          var pt1 = {lat: <? echo $latitude;?>, lng: <? echo $longitude;?>};
          // The map, centered at Uluru
          var map = new google.maps.Map(
              document.getElementById('map'), {zoom: 13, center: pt1});
          // The marker, positioned at pt1
          var marker1 = new google.maps.Marker({position: pt1, map: map});
          <? if(isset($rec) && isset($rec[0]) && isset($rec[1])){ ?>
          var pt2 = {lat: <? echo $rec[0];?>, lng: <? echo $rec[1];?>};
          var marker2 = new google.maps.Marker({
                    position: pt2, 
                    map: map,
                    icon: {                             
                      url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });
          <? } ?>
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
<TABLE BORDER=1 width="100%">
    <TR><TH></TH><TH>Date</TH><TH>Coordinates</TH><TH>Address</TH><TH></TH><TH><A style="font-size:10px" HREF="?survey_id=<? echo $_GET['survey_id'];
    if(isset($_GET['show_hidden'])){
        echo '">Hide X';
    }else{
        echo '&show_hidden=1">All';
    }
    ?></A></TH></TR>
<?
foreach($resps as $r){
    $id = $r[0];
    $date = $r[1];
    $lat_long = $r[2];
    $addr = $r[3];
    $geocode_fg = $r[4];
    $include_on_map_fg = $r[5];
    $ip_address = $r[8];



    if( (!empty($_POST['id']) && $_POST['id'] == $id) || 
        (!empty($_GET['id']) && $_GET['id'] == $id)   ){
        echo "<TR bgcolor=\"#def440\">";
    }else if(isset($_GET['show_hidden']) || $include_on_map_fg){
        echo "<TR>";
    }else{
        continue;
    }
    echo "<TD width=25>".$id.'</TD>';
    echo "<TD width=170>".$date.'</TD>';
    echo "<TD>". implode('</TD><TD>', array($lat_long, $addr)) . '</TD>';
    $ntests = select_speed_tests($ip_address);
    echo "<TD><a href=\"?survey_id=".$_GET['survey_id']."&id=".$id."\">".count($ntests)." Tests</TD>";
    echo '<TD><form action="" method="post">
        <input type="hidden" name="address" value="'.$addr.'">
        <input type="hidden" name="id" value="'.$id.'">
        <input type="submit" value="Lookup"></form></TD>';
    echo '<TD><form action="" method="post">';
    echo '<input type="hidden" name="id" value="'.$id.'">';
    if($include_on_map_fg){
        echo '<!-- $include_on_map_fg='.$include_on_map_fg.' -->';
        echo '<input type="hidden" name="include_on_map" value="0">';
        echo '<BUTTON type="submit">';
        echo '<i class="fa fa-check-circle" style="font-size:18px;color:green"></i>';
        echo '</BUTTON></form></TD>';
    }else{
        echo '<!-- $include_on_map_fg='.$include_on_map_fg.' -->';
        echo '<input type="hidden" name="include_on_map" value="1">';
        echo '<BUTTON type="submit">';
        echo '<i class="fa fa-remove" style="font-size:18px;color:red"></i>';
        echo '</BUTTON></form></TD>';
    }
    echo '</TR>'."\n";
    if( (!empty($_POST['id']) && $_POST['id'] == $id) || 
        (!empty($_GET['id']) && $_GET['id'] == $id)   ){
        echo "<TR><TD COLSPAN=\"7\" ALIGN=\"center\">";
        print_speed_tests($ip_address);
        echo "</TD></TR>";
    }
}
?>
</TABLE>

</BODY>
</HTML>
