<?php
include_once __DIR__ . "/../../config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Invalid request.");

// Collect and sanitize
$property_name = mysqli_real_escape_string($conn, $_POST['txtname'] ?? '');
$price         = (float) ($_POST['txtprice'] ?? 0);
$location      = mysqli_real_escape_string($conn, $_POST['txtlocation'] ?? '');
$status        = mysqli_real_escape_string($conn, $_POST['txtstatus'] ?? '');
$category_id   = (int) ($_POST['category_id'] ?? 0);
$img           = "";

// Validate category exists
$check_cat = mysqli_query($conn, "SELECT category_id FROM categories WHERE category_id = $category_id");
if (mysqli_num_rows($check_cat) === 0) die("Invalid category selected.");

// Upload image
$folder = __DIR__ . "/../../assets/images/";
if (isset($_FILES['files']) && $_FILES['files']['error'] === 0) {
    $img = time() . "_" . basename($_FILES['files']['name']);
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    if (!move_uploaded_file($_FILES['files']['tmp_name'], $folder . $img)) {
        die("Failed to upload image.");
    }
}

// Insert into database
$sql = "INSERT INTO properties
(property_name, price, `location`, `status`, category_id, img)
VALUES ('$property_name', $price, '$location', '$status', $category_id, '$img')";

if (!mysqli_query($conn, $sql)) {
    die("Insert failed: " . mysqli_error($conn));
}

// Redirect back to admin page with success message
header("Location: ../index.php?msg=property_added");
exit;