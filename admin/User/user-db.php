<?php
include_once __DIR__ . "/../../config.php";

// Get form values
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email    = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']); // PLAIN TEXT

// Validate
if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required.");
}

// Insert user (NO HASHING)
$sql = "INSERT INTO tbluser (user_name, email, pws)
        VALUES ('$username', '$email', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "User added successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>