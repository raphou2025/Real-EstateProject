<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "db_real-estate";   // 👈 change to your real estate database name

$conn = mysqli_connect($server, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>