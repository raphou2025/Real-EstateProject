<?php
// admin/Category/delete.php

// Include config and session
include_once __DIR__ . "/../../config.php";
include_once __DIR__ . "/../session.php"; // only if session is required

// Validate GET parameter
if (!isset($_GET['C_id']) || !ctype_digit($_GET['C_id'])) {
    http_response_code(400);
    exit('Invalid category ID');
}

$cid = (int)$_GET['C_id'];

// Delete category from database using prepared statement
$sql = "DELETE FROM categories WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500);
    exit('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
}

mysqli_stmt_bind_param($stmt, "i", $cid);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    exit('Execute failed: ' . htmlspecialchars(mysqli_stmt_error($stmt)));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect back to the admin dashboard
header("Location: ../index.php?msg=Category deleted successfully");
exit;