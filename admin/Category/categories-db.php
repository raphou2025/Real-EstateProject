<?php
include_once __DIR__ . "/../../config.php";

// Get form data safely
$category_name = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
$category_type = isset($_POST['category_type']) ? trim($_POST['category_type']) : '';
$description   = isset($_POST['category_description']) ? trim($_POST['category_description']) : '';

if ($category_name !== '' && $category_type !== '') {

    // Escape values to prevent SQL issues
    $category_name = mysqli_real_escape_string($conn, $category_name);
    $category_type = mysqli_real_escape_string($conn, $category_type);
    $description   = mysqli_real_escape_string($conn, $description);

    // Insert into categories table
    $sql = "INSERT INTO categories 
            (category_name, category_type, description)
            VALUES 
            ('$category_name', '$category_type', '$description')";

    $retval = mysqli_query($conn, $sql);

    if (!$retval) {
        die('Could not add category: ' . mysqli_error($conn));
    }

    echo "Add Category Successfully.";

} else {
    echo "Category name and category type cannot be empty.";
}

mysqli_close($conn);
?>