<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "quiz");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<link rel="stylesheet" href="css/mdb.min.css" />