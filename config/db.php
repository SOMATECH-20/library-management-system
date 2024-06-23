<?php
$servername = "SERVER";
$username = "USERNAME";
$password = "DB-PASSWORD";
$dbname = "DBNAME";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
