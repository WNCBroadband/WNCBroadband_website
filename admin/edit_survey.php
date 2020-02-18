<!DOCTYPE html>
<html lang="en-US">
<head><TITLE>Edit Survey</TITLE>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<SCRIPT>
    var num_new_questions = 0;
    function new_question(){
        num_new_questions++;
        var d = document.getElementById('new_question_block');
        var qn = num_new_questions + num_questions;
        d.innerHTML += '<TABLE border="0"><TR><TD valign="top"><B>New Question #'+qn+'</B> <i>(NEW)</i> </TD><TD rowspan="3"><TEXTAREA ROWS="10" COLS="80" NAME="question_id:NEW:'+qn+'"></TEXTAREA></TD></TR><TR><TD valign="top">Name:<INPUT TYPE="text" size="20" name="question_name:NEW:'+qn+'" value=""></TD></TR><TR><TD valign="top"></TD></TR></TABLE><HR>';
    }
</SCRIPT>
</head>
<body>

<?php
include('../db.php');

if(empty($_GET['survey_id'])){

    echo '<FORM METHOD="GET" ACTION="">
    Edit Survey: <SELECT name="survey_id">';

    $sql = "SELECT id,name FROM `Survey`";
    $result = $conn->query($sql);
    if ($conn->error) {
        echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    }
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        echo('<OPTION VALUE="'.$row['id'].'">'.$row['name'].'</OPTION>');
        }
    }
    $conn->close();
    echo '</SELECT><INPUT type="submit" value="Go"></FORM>';

}else if(!empty($_GET['action']) && $_GET['action']=='remove_question'){
    $survey_id = intval($_GET['survey_id']);
    $question_id = intval($_GET['question_id']);
    $sq_id = intval($_GET['sq_id']);
    echo '<CENTER>Are you sure you want to remove question_id = '.$question_id."?<BR>";
    echo '<BUTTON style="margin:20px" onclick="window.location=\'edit_survey.php?survey_id='.$survey_id.'\'">NO</BUTTON>';
    echo '<BUTTON style="margin:20px" onclick="window.location=\'edit_survey.php?survey_id='.$survey_id.'&action=confirm_remove_question&question_id='.$question_id.'&sq_id='.$sq_id.'\'">YES</BUTTON>';

}else if(!empty($_GET['action']) && $_GET['action']=='confirm_remove_question'){
    $survey_id = intval($_GET['survey_id']);
    $question_id = intval($_GET['question_id']);
    $sq_id = intval($_GET['sq_id']);

    $sql = "delete from Question where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$question_id);
    $stmt->execute();
    if ($conn->error) {
        echo "DB Error deleting question: ".$conn->error."<BR>";
    }else{

        $sql = "delete from Survey_Questions where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$sq_id);
        $stmt->execute();
        if ($conn->error) {
            echo "DB Error deleting survey_question: ".$conn->error."<BR>";
        }else{
            echo "Question deleted.";
            echo "<SCRIPT>setTimeout(function(){window.location='edit_survey.php?survey_id=".$survey_id."';},1000);</script>";
        }

    }

}else if(!empty($_GET['action']) && $_GET['action']=='edit_order'){
    $survey_id = intval($_GET['survey_id']);
    $question_id = intval($_GET['question_id']);
    $sq_id = intval($_GET['sq_id']);
    $sq_order = intval($_GET['sq_order']);

    $sql = "UPDATE Survey_Questions sq SET sq.display_order = ? WHERE sq.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$sq_order,$sq_id);
    $stmt->execute();
    if ($conn->error) {
        echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    }else{
        echo "<script>window.location='edit_survey.php?survey_id=".$survey_id."'</script>";
    }

}else if(!empty($_POST['action']) && $_POST['action']=='save'){
    #echo '<PRE>';
    #print_r($_POST);
    #echo '</PRE>';
    $survey_id = intval($_GET['survey_id']);
    foreach ($_POST as $key => $value){
        if(startsWith($key,"question_id:")){
            list($qtest, $question_id_txt) = explode(':',$key,2);
            #echo "key=$key question_id_txt=$question_id_txt qtest=$qtest<BR>";
            if(startsWith($question_id_txt,"NEW")){
                // new question
                list($qtest, $new_question_order_txt) = explode(':',$question_id_txt,2);
                $new_question_order = intval($new_question_order_txt);
                $question_name = $_POST['question_name:NEW:'.$new_question_order];
                echo "New Question ".$new_question_order."<BR>";
                echo "question_name=$question_name<BR>";
                if(empty($_POST['question_name:'.$question_id])){
                    echo "Error inserting new question: name is empty<BR>";
                    continue;
                }

                $sql1 = "insert into Question (name,display_html) values(?,?)";
                $stmt = $conn->prepare($sql1);
                $stmt->bind_param("ss", $question_name, $value);
                $stmt->execute();
                if ($conn->error) {
                    echo "DB Error inserting question: ".$conn->error."<BR>";
                    continue;
                }
                $question_id = $conn->insert_id;
                echo "Inserted question_id=".$question_id.'<BR>';

                $sql2 = "insert into Survey_Questions (survey_id, question_id, display_order) values (?,?,?)";
                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("iii",$survey_id, $question_id, $new_question_order);
                $stmt->execute();
                if ($conn->error) {
                    echo "DB Error inserting qurvey_questions: ".$conn->error."<BR>";
                    continue;
                }
                $survey_question_id = $conn->insert_id;
                echo "Inserted survey_question_id=".$survey_question_id.'<BR>';



            }else{
                // update question
                $question_id = intval($question_id_txt);
                #echo "Processing question_id = $question_id : ";
                if(empty($_POST['question_name:'.$question_id])){
                    echo "Error updating question_id=".$question_id.": name is empty<BR>";
                    continue;
                }
                $question_name = $_POST['question_name:'.$question_id];
                
                $sql = "UPDATE Question q SET q.name=?, q.display_html=? where q.id=?";
                $stmt = $conn->prepare($sql);
                if(!$stmt){
                    echo "DB Error updating question_id=".$question_id.": ".str_replace('\'', '\\\'', $conn->error)."<BR>";
                    continue;
                }
                $stmt->bind_param("ssi",$question_name, $value, $question_id);
                $stmt->execute();
                if ($conn->error) {
                    echo "DB Error updating question_id=".$question_id.": ".str_replace('\'', '\\\'', $conn->error)."<BR>";
                    continue;
                }
                $affected_rows = $stmt->affected_rows;
                if($affected_rows == 1){
                    echo "Successfully Updated question_id=".$question_id."<BR>";
                }else{
                    echo "No change to question_id=".$question_id."<BR>";
                }
            }
        }
    }

    echo '<BR><CENTER>';
    echo '<Button onclick="window.location=\'edit_survey.php?survey_id='.$survey_id.'\'">Edit Survey</Button>';
    echo '<Button onclick="window.location=\'validate_survey.php?survey_id='.$survey_id.'\'">View / Validate Survey</Button>';
    echo "</CENTER>";


}else{
    $validate=False;
    if(!empty($_POST['action']) && $_POST['action']=='validate'){
        $validate=True;
    }
    $survey_id = intval($_GET['survey_id']);


    echo '<FORM METHOD="POST" ACTION=""><INPUT type="hidden" name="survey_id" value="'.$survey_id.'">';

    $sql = "
    SELECT sq.id as 'sq_id', q.id as 'id', q.name as 'name', sq.display_order as 'display_order', q.display_html as 'html' 
    FROM Question q, Survey s, Survey_Questions sq
    WHERE s.id = ?
      AND sq.survey_id = s.id
      AND sq.question_id = q.id
    ORDER BY sq.display_order asc
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$survey_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($conn->error) {
        echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    }
    $num_questions = 0;
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
        $num_questions++;
        echo '<TABLE border="1"><TR><TD valign="top">';
        echo '<B>Question #'.$row['display_order'].'</B> <i>(id='.$row['id'].')</i> ';
        echo '<A HREF="edit_survey.php?survey_id='.$survey_id.'&question_id='.$row['id'].'&action=edit_order&sq_id='.$row['sq_id'].'&sq_order='.(intval($row['display_order'])-1).'"><i class="fa fa-arrow-up" style="color:black"></i></A>';
        echo '<A HREF="edit_survey.php?survey_id='.$survey_id.'&action=edit_order&sq_id='.$row['sq_id'].'&sq_order='.(intval($row['display_order'])+1).'"><i class="fa fa-arrow-down" style="color:black"></i></A>';
        echo '<A HREF="edit_survey.php?survey_id='.$survey_id.'&action=remove_question&sq_id='.$row['sq_id'].'&question_id='.$row['id'].'"><i class="fa fa-trash-o"></i></A>';
        echo '</TD><TD rowspan="3">';
        echo '<TEXTAREA ROWS="10" COLS="80" NAME="question_id:'.$row['id'].'">';
        echo($row['html']);
        echo '</TEXTAREA>';
        echo '</TD></TR><TR><TD valign="top">';
        echo 'Name:<INPUT TYPE="text" size="20" name="question_name:'.$row['id'].'" value="'.$row['name'].'">';
        echo '</TD></TR><TR><TD valign="top">';
        if($validate){
            echo '<B style="font-size:24px">Validation:</B>';
            if(!empty($_POST[$row['name']])){
                echo '<i class="fa fa-check-circle" style="font-size:48px;color:green"></i>';
            }else{
                echo '<i class="fa fa-remove" style="font-size:48px;color:red"></i>';
            }
        }
        echo '</TD></TR></TABLE>';
        echo '<HR>';
        }
    }else{
        echo("No Quesions Found");
    }
    $conn->close();
    echo '<DIV id="new_question_block"></DIV>';
    echo '<SCRIPT>var num_questions = '.$num_questions.';</SCRIPT>';
    echo '<CENTER><BUTTON type="button" onclick="new_question()">Add New Question</BUTTON></CENTER>';
    echo '<HR>';
    echo '<input type="hidden" name="action" value="save">';
    echo '<input type="hidden" id="num_questions" name="num_questions" value="'.$num_questions.'">';
    echo '<CENTER><INPUT TYPE="submit" VALUE="Save"></CENTER></FORM>';


}


?>
</body>
</html>

