<?php
// admin/Property/update_property.php

include_once __DIR__ . "/../../config.php";

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// 1) Collect inputs (names must match your edit form)
$pid        = isset($_POST['P_id']) && ctype_digit($_POST['P_id']) ? (int)$_POST['P_id'] : 0;
$name       = $_POST['txtname']      ?? '';
$price      = $_POST['txtprice']     ?? '';
$location   = $_POST['txtlocation']  ?? '';
$status     = $_POST['txtstatus']    ?? '';
$categoryId = $_POST['category_id']  ?? '';
$oldImg     = $_POST['old_img']      ?? '';

// 2) Basic validation
$errors = [];
if ($pid <= 0)                                   $errors[] = 'Invalid property ID.';
if ($name === '')                                $errors[] = 'Property name is required.';
if ($price === '' || !is_numeric($price))        $errors[] = 'Price must be numeric.';
if ($location === '')                            $errors[] = 'Location is required.';
if ($status === '')                              $errors[] = 'Status is required.';
if ($categoryId === '' || !ctype_digit($categoryId)) $errors[] = 'Valid category is required.';

if ($errors) {
    echo "<h3>Validation errors</h3><ul>";
    foreach ($errors as $e) echo "<li>" . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "</ul>";
    exit;
}

// 3) Image handling
$uploadDir = __DIR__ . "/../../assets/images/"; // adjust if your images live elsewhere
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$newImgName = $oldImg; // default: keep old image

if (isset($_FILES['files']) && $_FILES['files']['error'] === UPLOAD_ERR_OK) {
    $originalName = basename($_FILES['files']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if (!in_array($ext, $allowed, true)) {
        exit('Unsupported image type. Allowed: ' . implode(', ', $allowed));
    }

    $newImgName = uniqid('prop_', true) . '.' . $ext;
    $targetPath = $uploadDir . $newImgName;

    if (!move_uploaded_file($_FILES['files']['tmp_name'], $targetPath)) {
        exit('Failed to upload image.');
    }

    // Optionally remove old image if it existed and is different
    if ($oldImg && $oldImg !== $newImgName) {
        @unlink($uploadDir . $oldImg);
    }
}

// 4) Update database (prepared statement)
$sql = "UPDATE properties
        SET property_name = ?, 
            price = ?, 
            location = ?, 
            `status` = ?, 
            category_id = ?, 
            img = ?
        WHERE property_id = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    exit('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
}

$priceFloat = (float)$price;
$categoryIdInt = (int)$categoryId;

mysqli_stmt_bind_param(
    $stmt,
    "sdssisi",
    $name,
    $priceFloat,
    $location,
    $status,
    $categoryIdInt,
    $newImgName,
    $pid
);

if (!mysqli_stmt_execute($stmt)) {
    exit('Update failed: ' . htmlspecialchars(mysqli_stmt_error($stmt)));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// 5) Redirect back to listing (from /admin/Property/ to /admin/)
header("Location: ../index.php");
exit;