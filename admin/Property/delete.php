<?php
// admin/Property/delete.php

// 1) Only include config (and session if needed). Do NOT include index.php here.
include_once __DIR__ . "/../../config.php";
include_once __DIR__ . "/../session.php"; // only if it doesn't echo HTML

// 2) Validate GET param
if (!isset($_GET['P_id']) || !ctype_digit($_GET['P_id'])) {
    http_response_code(400);
    exit('Invalid property ID');
}

$pid = (int)$_GET['P_id'];

// 3) Execute delete (prepared statement recommended)
$sql = "DELETE FROM properties WHERE property_id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500);
    exit('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
}

mysqli_stmt_bind_param($stmt, "i", $pid);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    exit('Execute failed: ' . htmlspecialchars(mysqli_stmt_error($stmt)));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// 4) Redirect back to the listing page. Adjust if your list page is elsewhere.
header("Location: ../index.php"); // this assumes list page is /admin/index.php
exit;