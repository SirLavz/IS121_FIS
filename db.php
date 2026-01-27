<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "is121_exam";   // database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

date_default_timezone_set("Asia/Manila");
?>
