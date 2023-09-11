<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "grocery";
//$conn =  mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
else{
    //echo "succeeded";
}

?>