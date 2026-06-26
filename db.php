<?php
$servername = "sql113.infinityfree.com";
$username = "if0_42270057";
$password = "S3UzldLaGLM";
$dbname = "if0_42270057_ecommerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>