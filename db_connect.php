<?php

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


