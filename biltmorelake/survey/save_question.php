<?PHP


echo "UUID=".$_GET['uuid']."; ";
echo "name=".$_GET['name'].";  ";
echo "survey_id=".$_GET['survey_id']."; ";
echo "value=".$_GET['value']."; ";
echo "type=".$_GET['type']."\n";


include('../../db.php');

function get_response($survey_id){
    // Select
    $response_id = select_response();
    // if not found, insert
    if(is_null($response_id)){
        echo "calling insert_response($survey_id)\n";
        $response_id = insert_response($survey_id);
        echo "Inserted response_id=".$response_id."\n";
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
        echo "DB Error inserting response: ".$conn->error."\n";
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
        echo "DB Error inserting response: ".$conn->error."\n";
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
                echo "DB Error inserting response: ".$conn->error."\n";
                echo "SQL: $sql\n";
                exit();
            }
            $stmt->bind_param("si",$_GET['value'], $response_id);
            $stmt->execute();
            if($conn->error){
                echo "DB Error inserting response: ".$conn->error."\n";
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
        echo "DB Error inserting response: ".$conn->error."\n";
        exit;
    }
    $stmt->bind_param("isss", $survey_id, $_SERVER['REMOTE_ADDR'],$_GET['uuid'], $_SERVER['HTTP_USER_AGENT'] );
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error inserting response: ".$conn->error."\n";
        exit;
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


######### Main ##############################
if(!empty($_GET['survey_id'])){

    $survey_id = intval($_GET['survey_id']);

    $response_id = get_response($survey_id);


    if($_GET['name']!="comments"){

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
