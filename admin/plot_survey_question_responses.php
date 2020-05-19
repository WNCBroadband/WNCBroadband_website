<?php
include('../db.php');

function get_data(){
    global $conn;
    if( !empty($_GET['survey_id']) && !empty($_GET['question_id'])
    ){

        $sql = "
        SELECT answer
        FROM Survey_Questions_Responses
        WHERE survey_id = ?
          AND question_id = ?
        ";

        $survey_id = intval($_GET['survey_id']);
        $question_id = intval($_GET['question_id']);

        $stmt = $conn->prepare($sql);
        if(!$stmt){
            echo "console.log('Error: ".str_replace('\'', '\\\'', $conn->error)."');\n";
            return False;
        }
        $stmt->bind_param("ii",$survey_id, $question_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($conn->error) {
            echo "console.log('Error: ".str_replace('\'', '\\\'', $conn->error)."');\n";
            return False;
        }
        if ($result->num_rows > 0) {
            // output data of each row
            $str = "var x = [";
            while($row = $result->fetch_assoc()) {
                $str .= "'" . $row['answer'] . "',";
            }
            $str .= "];\n";
            echo $str;
            return True;
        }else{
            echo "console.log('Error: no results for survey_id=".$survey_id." and question_id=".$question_id."');\n";
            return False;
        }
    }else{
        echo "console.log('Error: could not fetch data, need survey_id and question_id');\n";
        return False;
    }
}
?>

<!DOCTYPE html>
<HTML>
<HEAD>
<!-- Load plotly.js into the DOM -->
    <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
</head>
<SCRIPT>
function go(){
    var x = [];
    <?php get_data(); ?>
    var trace = {
        x: x,
        type: 'histogram',
      };
    var data = [trace];
    Plotly.newPlot('myDiv', data);
}
</SCRIPT>
<STYLE>
    #myDiv {
        width: 100%;
        height: 300px;
    }
</STYLE>
</HEAD>
<body onload="go()">
    <div id='myDiv'><!-- Plotly chart will be drawn inside this DIV --></div>
</body>
</HTML>
