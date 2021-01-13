<?php
include('../db.php');

function get_data(){
    global $conn;
    if( !empty($_GET['survey_id']) && !empty($_GET['question_id1'])&& !empty($_GET['question_id2'])
    ){

        $sql = "
        SELECT response_id, 
        GROUP_CONCAT(answer ORDER BY question_id ASC SEPARATOR ',') as answers 
        FROM `Survey_Questions_Responses` 
        WHERE `survey_id` = ?
        and ( question_id = ? or question_id = ?) group by response_id
        ";

        $survey_id = intval($_GET['survey_id']);
        $question_id1 = intval($_GET['question_id1']);
        $question_id2 = intval($_GET['question_id2']);

        $stmt = $conn->prepare($sql);
        if(!$stmt){
            echo "Error: ".str_replace('\'', '\\\'', $conn->error)."\n";
            return False;
        }
        $stmt->bind_param("iii",$survey_id, $question_id1, $question_id2);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($conn->error) {
            echo "Error: ".str_replace('\'', '\\\'', $conn->error)."\n";
            return False;
        }
        if ($result->num_rows > 0) {
            $q1_answers = array();
            $q2_answers = array();
            $q1q2_counts = array();
            // capture data of each row
            while($row = $result->fetch_assoc()) {
                $both_ans = $row['answers'];
                list($ans1, $ans2) = explode(",", $both_ans, 2);

                $q1_answers[ $ans1 ] = 1;  // get list of answers, no duplicates
                $q2_answers[ $ans2 ] = 1;

                if( array_key_exists( $both_ans, $q1q2_counts) ){
                    // incriment count
                    $q1q2_counts[ $both_ans ]++;
                }else{
                    // set value to 1
                    $q1q2_counts[ $both_ans ] = 1;
                }

            }
            // output HTML table
            echo "<TABLE BORDER=1><TR><TD></TD>";
            foreach($q2_answers as $key2 => $value2){
                if($key2 == ""){continue;}
                echo "<TH>".$key2."</TH>";
            }
            echo "</TR>\n";
            foreach($q1_answers as $key1 => $value1){
                echo "<TR><TH>".$key1."</TH>";
                foreach($q2_answers as $key2 => $value2){
                    if($key2 == ""){continue;}
                    echo "<TD>" . $q1q2_counts[ $key1.",".$key2 ] . "</TD>";     
                }
                echo "</TR>\n";
            }
            echo "</TABLE>";


            return True;
        }else{
            echo "Error: no results for survey_id=".$survey_id." and question_id1=".$question_id1."and question_id2=".$question_id2."\n";
            return False;
        }
    }else{
        echo "Error: could not fetch data, need survey_id and question_id1 and question_id2\n";
        return False;
    }
}
?>

<!DOCTYPE html>
<HTML>
<body >
    <?php get_data(); ?>
</body>
</HTML>
