<?php
session_start();
include_once("config.php");

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// match user-db.php logic
$password = md5($password);

$sql = "SELECT * FROM users
        WHERE username='$username'
        AND password='$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $_SESSION['admin'] = $username;
    header("Location: admin/index.php");
    exit();

} else {
    echo "Login failed. <a href='index.php'>Try again</a>";
}

mysqli_close($conn);
?>