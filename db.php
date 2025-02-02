<?php
$servername = "localhost";
$servername = "192.168.0.100";
$username = "finallap_finallap";
$password = "XUEkUcykdthay9zWabf";
$database = "finallap_finallap";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

