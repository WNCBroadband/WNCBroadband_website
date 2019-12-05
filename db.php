<?php
$servername = "138.68.228.126";
$username = "drawertl_westngn";
$password = "dbpass_adh4enal";
$dbname = "drawertl_westngn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
    exit(0);
}

function startsWith ($string, $startString){ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 

?>
