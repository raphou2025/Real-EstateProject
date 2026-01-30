<?php
// admin/Category/update_category.php
include_once __DIR__ . "/../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and validate category ID
    $cid = isset($_POST['C_id']) && ctype_digit($_POST['C_id']) ? (int)$_POST['C_id'] : 0;
    if ($cid <= 0) {
        exit('Invalid category ID.');
    }

    // Get and sanitize inputs
    $category_name = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
    $description   = isset($_POST['description']) ? trim($_POST['description']) : '';

    if ($category_name === '') {
        exit('Category name is required.');
    }

    // Update database using prepared statement
    $sql = "UPDATE categories SET category_name = ?, description = ? WHERE category_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        exit('Failed to prepare statement: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $category_name, $description, $cid);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        header("Location: ../index.php?msg=Category updated successfully");
        exit;
    } else {
        exit('Database update failed: ' . mysqli_error($conn));
    }

} else {
    exit('Invalid request method.');
}