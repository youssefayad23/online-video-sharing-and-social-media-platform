<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "streaming_platform";
$con = mysqli_connect($host, $user, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
