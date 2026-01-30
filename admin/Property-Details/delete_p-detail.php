<?php
include_once __DIR__ . "/../../config.php";

$details_id = isset($_GET['details_id']) ? (int)$_GET['details_id'] : 0;

$check = mysqli_query($conn, "
    SELECT details_id FROM properties_details WHERE details_id = $details_id
");

if (mysqli_num_rows($check) === 0) {
    die("Details not found.");
}

mysqli_query($conn, "
    DELETE FROM properties_details WHERE details_id = $details_id
") or die(mysqli_error($conn));

header("Location: ../../admin/index.php?tab=details&msg=deleted");
exit;