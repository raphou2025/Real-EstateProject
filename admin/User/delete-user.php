<?php
include_once __DIR__ . "/../../config.php";

// Get user id safely
$user_id = isset($_GET['U_id']) ? $_GET['U_id'] : '';

if ($user_id != '') {

    // Delete user
    $sql = "DELETE FROM tbluser WHERE user_id = '$user_id'";

    $retval = mysqli_query($conn, $sql);

    if (!$retval) {
        die('Could not delete user: ' . mysqli_error($conn));
    }

    echo "Delete User Successfully.";
} else {
    echo "User ID not found.";
}

mysqli_close($conn);
?>