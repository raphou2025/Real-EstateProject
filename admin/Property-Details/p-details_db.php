<?php
include_once __DIR__ . "/../../config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

// Collect and sanitize inputs
$property_id = isset($_POST['property_id']) ? (int)$_POST['property_id'] : 0;
$size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : '';
$area = isset($_POST['area']) ? mysqli_real_escape_string($conn, $_POST['area']) : '';
$bedrooms = isset($_POST['bedrooms']) ? (int)$_POST['bedrooms'] : 0;
$bathrooms = isset($_POST['bathrooms']) ? (int)$_POST['bathrooms'] : 0;
$kitchen_rooms = isset($_POST['kitchen_rooms']) ? (int)$_POST['kitchen_rooms'] : 0;
$dining_rooms = isset($_POST['dining_rooms']) ? (int)$_POST['dining_rooms'] : 0;
$living_rooms = isset($_POST['living_rooms']) ? (int)$_POST['living_rooms'] : 0;
$description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';

// 1️⃣ Validate the selected property exists
$check = mysqli_query($conn, "SELECT property_id FROM properties WHERE property_id = $property_id");
if (mysqli_num_rows($check) === 0) {
    die("Error: Selected property does not exist.");
}

// 2️⃣ Insert the new details row
$sql = "
INSERT INTO properties_details 
(property_id, size, area, bedrooms, bathrooms, kitchen_rooms, dining_rooms, living_rooms, description)
VALUES
($property_id, '$size', '$area', $bedrooms, $bathrooms, $kitchen_rooms, $dining_rooms, $living_rooms, '$description')
";

if (mysqli_query($conn, $sql)) {
    header("Location: ../../admin/index.php?tab=details&msg=created");
    exit;
} else {
    die("Database error: " . mysqli_error($conn));
}