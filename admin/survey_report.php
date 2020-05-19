<?
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

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
    return;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WestNGN | Survey</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <!--<link href="../css/style.css" rel="stylesheet" type="text/css"> -->
  <STYLE>
        .report_row {
            width: 100%;
            border: 1px solid black;
            vertical-align: top;
            background-color: #DDDDDD;
        }
        .report_question {
            margin: 20px;
            border: 1px solid black;
            width:40%;
            display: inline-block;
            vertical-align: top;
            background-color: white;
        }
        .report_plot {
            width: 50%;
            display: inline-block;
        }
  </STYLE>
</head>

<body>
          <form id="fullsurvey" class="form" method="POST" onsubmit="return false"> 
<?

//echo '<INPUT type="hidden" name="survey_id" value="1">';


$sql = "
SELECT q.id as 'question_id', q.display_html as 'html' 
FROM Question q, Survey_Questions sq
WHERE sq.survey_id = ?
  AND sq.question_id = q.id
ORDER BY sq.display_order asc
";
$stmt = $conn->prepare($sql);
if(!$stmt){
    echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    return;
}

$survey_id = intval($_GET['survey_id']);
$stmt->bind_param("i",$survey_id);
$stmt->execute();
$result = $stmt->get_result();


if ($conn->error) {
    echo "<script>alert('Error: ".str_replace('\'', '\\\'', $conn->error)."');</script>";
    return;
}
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<DIV class="report_row">';
        echo '<DIV class="report_question">';
        echo($row['html']);
        echo '</DIV>';
        echo '<DIV class="report_plot">';
        echo '<iframe height="330" width="100%" src="/admin/plot_survey_question_responses.php?survey_id='.$survey_id.'&question_id='.$row['question_id'].'"></iframe>';
        echo '</DIV>';
        echo '</DIV>';
    }
}else{
    echo("No Quesions Found");
}
$conn->close();
?>
      
          </form>

</body>
</html>


