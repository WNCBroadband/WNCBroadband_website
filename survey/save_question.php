<?PHP


echo "UUID=".$_GET['uuid']."; ";
echo "name=".$_GET['name'].";  ";
echo "survey_id=".$_GET['survey_id']."; ";
echo "value=".$_GET['value']."; ";
echo "type=".$_GET['type']."\n";

try{
    $inc_worked = include('../db.php');
}catch(Exception $e) {
    echo 'Caught exception: '.$e->getMessage()."\n";
}

if($conn){
    echo "Connected to database.\n";
}else{
    echo "NOT Connected to database.\n";
}


function get_response($survey_id){
    // Select
    $response_id = select_response();
    // if not found, insert
    if(is_null($response_id)){
        echo "calling insert_response($survey_id)\n";
        $response_id = insert_response($survey_id);
        echo "Inserted response_id=".$response_id."\n";
        if(is_null($response_id)){
            // Race condition, try to select again
            $response_id = select_response();
            if(is_null($response_id)){
                echo "Error: get_response(): select/insert/select did not work";
                exit;
            }
        }
    }else{
        echo "Found response_id=".$response_id."\n";
    }
    if($_GET['name'] == 'comments'){
        
        update_response_comments($response_id);
    }
    if(!empty($_GET['geoip_latitude']) && !empty($_GET['geoip_longitude'])){
        update_response_geoip($response_id);
    }

    update_response_address($response_id);

    return $response_id;
}

function select_response(){
    global $conn;
    $sql = "select id from Responses where uuid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$_GET['uuid']);
    $stmt->execute();
    if($conn->error){
        echo "DB Error select response: ".$conn->error."\n";
    }
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        //echo "Found response_id=".$row['id']."\n";
        return $row['id'];
    }
    return NULL;
}

function update_response_comments($response_id){
    global $conn;
    $sql = "UPDATE Responses set comments=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$_GET['value'],$response_id);
    $stmt->execute();
    if($conn->error){
        echo "update_response_comments(): DB Error inserting response: ".$conn->error."\n";
    }else{
        echo "Updated response: comments\n";
    }
}
function update_response_geoip($response_id){
    global $conn;
    //$_GET['geoip_latitude'], $_GET['geoip_longitude']
    $sql = "UPDATE Responses set geoip_latitude=?, geoip_longitude=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $_GET['geoip_latitude'], $_GET['geoip_longitude'],$response_id);
    $stmt->execute();
    if($conn->error){
        echo "update_response_geoip(): DB Error inserting response: ".$conn->error."\n";
    }else{
        echo "updated response: geoip\n";
    }
}
function update_response_address($response_id){
    global $conn;
    // $_GET['street_address'], $_GET['city_address'], $_GET['state_address'], $_GET['zip_address']
    $names_arr = array('street_address' => 'home_address_street', 
                       'city_address' => 'home_address_city',
                       'state_address' => 'home_address_state',
                       'zip_address' => 'home_address_zip');
    foreach ($names_arr as $name => $dbname){
        if($_GET['name'] == $name){
            $sql = "UPDATE Responses set $dbname=?  where id = ?";
            $stmt = $conn->prepare($sql);
            if(!$stmt){
                echo "update_response_address(): DB Error inserting response: ".$conn->error."\n";
                echo "SQL: $sql\n";
                exit();
            }
            $stmt->bind_param("si",$_GET['value'], $response_id);
            $stmt->execute();
            if($conn->error){
                echo "update_response_address(): DB Error inserting response: ".$conn->error."\n";
                exit();
            }else{
                echo "Updated response: $name\n";
            }
        }
    }
}

function insert_response($survey_id){
    global $conn;
    $sql1 = "insert into Responses (survey_id, ip_address, uuid, HTTP_USER_AGENT) values(?,?,?,?)";
    $stmt = $conn->prepare($sql1);
    if(!$stmt){
        echo "insert_response(): DB Error inserting response: ".$conn->error."\n";
        return NULL;
    }
    $stmt->bind_param("isss", $survey_id, $_SERVER['REMOTE_ADDR'],$_GET['uuid'], $_SERVER['HTTP_USER_AGENT'] );
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error inserting response: ".$conn->error."\n";
        return NULL;
    }
    $response_id = $conn->insert_id;
    return $response_id;
}

function get_question($question_name){
    global $conn;
    $sql = "select id from Question where name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$question_name);
    $stmt->execute();
    if($conn->error){
        echo "DB Error select Question: ".$conn->error."\n";
    }
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['id'];
    }
    echo "Error getting question_id, no rows found";
    exit();
}

function delete_response_question($response_id, $question_id){
    global $conn;
    $sql = "Delete from Survey_Questions_Responses where response_id=? and question_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$response_id,$question_id);
    $stmt->execute();
    if($conn->error){
        echo "DB Error deleting Survey_Questions_Responses: ".$conn->error."\n";
        exit();
    }
    echo "Deleted ".$conn->affected_rows." rows from Survey_Questions_Responses\n";
}

function delete_response_question_answer($response_id, $question_id, $answer){
    global $conn;
    $sql = "Delete from Survey_Questions_Responses where response_id=? and question_id=? and answer=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis",$response_id,$question_id,$answer);
    $stmt->execute();
    if($conn->error){
        echo "DB Error deleting Survey_Questions_Responses: ".$conn->error."\n";
        exit();
    }
    echo "Deleted ".$conn->affected_rows." rows from Survey_Questions_Responses\n";
    return $conn->affected_rows;
}

function insert_survey_question_response($survey_id, $question_id, $response_id, $answer){
    global $conn;
    $sql = "insert into Survey_Questions_Responses (survey_id,question_id,response_id,answer) values(?,?,?,?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis",$survey_id,$question_id,$response_id,$answer);
    $stmt->execute();
    if($conn->error){
        echo "DB Error inserting Survey_Questions_Responses: ".$conn->error."\n";
        echo "insert_survey_question_response($survey_id, $question_id, $response_id, $answer)\n";
        exit();
    }
    echo "Inserted ".$conn->affected_rows." rows from Survey_Questions_Responses\n";
    return $conn->affected_rows;
}

function insert_speed_test($response_id){
    global $conn;
    $uuid = $_GET['uuid'];
    list($speedtest,$report_type,$up_down) = explode("__",$_GET['name']);

    if(empty($uuid)){ echo "insert_speed_test() no uuid";return;}
    if(empty($report_type)){ echo "insert_speed_test() no report_type";return;}
    if(empty($up_down)){ echo "insert_speed_test() no up_down";return;}

    $sql1 = "select id from Responses_speed_data where UUID = ? and report_type = ?";
    $sql2 = "insert into Responses_speed_data (ip_address,response_id, UUID, report_type) values (?,?,?,?)";
    $sql3 = "update Responses_speed_data set download_speed = ? where id = ?";
    $sql4 = "update Responses_speed_data set upload_speed = ? where id = ?";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ss",$uuid,$report_type);
    $stmt1->execute();
    if($conn->error){
        echo "DB Error inserting Responses_speed_data: ".$conn->error."\n";
        echo "select Responses_speed_data($uuid)\n";
        exit();
    }
    $result1 = $stmt1->get_result();
    $id = NULL;
    if($result1->num_rows > 0){
        $row = $result1->fetch_assoc();
        echo "Found  Responses_speed_data id=$id for UUID=$uuid and report_type=$report_type\n";
        $id = $row['id'];
    }
    if(is_null($id)){
        echo "Inserting into Responses_speed_data.\n";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("siss",$_SERVER['REMOTE_ADDR'],$response_id,$uuid,$report_type);
        $stmt2->execute();
        if(!$conn->error){
            $id = $conn->insert_id;
            echo "inserted into Responses_speed_data id=$id for (".$_SERVER['REMOTE_ADDR'].",$response_id,$uuid,$report_type)\n";
        }
        if(is_null($id)){
            echo "Could not insert into Responses_speed_data, selecting again\n";
            // Race condition here, try selecting again
            $stmt1_b = $conn->prepare($sql1);
            $stmt1_b->bind_param("ss",$uuid,$report_type);
            $stmt1_b->execute();
            if($conn->error){
                echo "DB Error inserting Responses_speed_data: ".$conn->error."\n";
                echo "select from Responses_speed_data(".$_SERVER['REMOTE_ADDR'].",$response_id,$uuid)\n";
                exit();
            }
            $result1_b = $stmt1_b->get_result();
            if($result1_b->num_rows > 0){
                $row = $result1_b->fetch_assoc();
                $id = $row['id'];
                echo "Found Responses_speed_data id=$id for UUID=$uuid and report_type=$report_type\n";
            }
            if(!isset($id)){
                echo "DB Error inserting Responses_speed_data (could not select after insert): ".$conn->error."\n";
                echo "insert Responses_speed_data(".$_SERVER['REMOTE_ADDR'].",$response_id,$uuid)\n";
                exit();
            }

        }
    }
    if($up_down == 'download'){
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("di",$_GET['value'],$id);
        $stmt3->execute();
        if($conn->error){
            echo "DB Error inserting Responses_speed_data: ".$conn->error."\n";
            echo "insert Responses_speed_data.download=".$_GET['value']."\n";
            exit();
        }
        echo "Updated ".$conn->affected_rows." rows into Responses_speed_data.id=$id, download=".$_GET['value']."\n";
    }
    if($up_down == 'upload'){
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bind_param("di",$_GET['value'],$id);
        $stmt4->execute();
        if($conn->error){
            echo "DB Error inserting Responses_speed_data: ".$conn->error."\n";
            echo "insert Responses_speed_data.upload=".$_GET['value']."\n";
            exit();
        }
        echo "Updated ".$conn->affected_rows." rows into Responses_speed_data.id=$id, upload=".$_GET['value']."\n";
    }
}


######### Main ##############################

if(isset($_GET['survey_id'])){

    $survey_id = intval($_GET['survey_id']);

    echo "getting response_id.  ";
    $response_id = get_response($survey_id);
    echo "response_id = $response_id.";


    if(startsWith($_GET['name'],'SPEEDTEST__')){
            insert_speed_test($response_id);                   
    }else if($_GET['name']!="comments"){

        $question_id = get_question($_GET['name']);

        //echo "question_id=".$question_id." response_id=".$response_id."\n";

        if($_GET['type'] =='radio' || $_GET['type']=='text'){
            // Delete all rows with response_id and question_id
            delete_response_question($response_id, $question_id);
            // insert
            insert_survey_question_response($survey_id, $question_id, $response_id, $_GET['value']);
        }else if($_GET['type'] == 'checkbox'){
            // Delete all rows with response_id and question_id and answer
            if( delete_response_question_answer($response_id, $question_id, $_GET['value']) == 0){
                // insert
                insert_survey_question_response($survey_id, $question_id, $response_id, $_GET['value']);
            }
        }
    }

}


?>
