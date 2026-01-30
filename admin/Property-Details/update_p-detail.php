<?php
include_once __DIR__ . "/../../config.php";

$details_id = (int)$_POST['details_id'];

$check = mysqli_query($conn, "
    SELECT details_id FROM properties_details WHERE details_id = $details_id
");
if (mysqli_num_rows($check) === 0) {
    die("Details not found.");
}

$size = mysqli_real_escape_string($conn, $_POST['size']);
$area = mysqli_real_escape_string($conn, $_POST['area']);
$bedrooms = (int)$_POST['bedrooms'];
$bathrooms = (int)$_POST['bathrooms'];
$kitchen_rooms = (int)$_POST['kitchen_rooms'];
$dining_rooms = (int)$_POST['dining_rooms'];
$living_rooms = (int)$_POST['living_rooms'];
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "
UPDATE properties_details SET
    size='$size',
    area='$area',
    bedrooms=$bedrooms,
    bathrooms=$bathrooms,
    kitchen_rooms=$kitchen_rooms,
    dining_rooms=$dining_rooms,
    living_rooms=$living_rooms,
    description='$description'
WHERE details_id=$details_id
";

mysqli_query($conn, $sql) or die(mysqli_error($conn));

header("Location: ../../admin/index.php?tab=details&msg=updated");
exit;