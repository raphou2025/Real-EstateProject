<?php
// admin/Category/edit.php
include_once __DIR__ . "/../../config.php";

// Get category ID safely
$cid = isset($_GET['C_id']) && ctype_digit($_GET['C_id']) ? (int)$_GET['C_id'] : 0;
if ($cid <= 0) {
    http_response_code(400);
    exit('Invalid category id');
}

// Fetch category (now includes category_type)
$sql = "SELECT category_id, category_name, category_type, description 
        FROM categories 
        WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $cid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$row) {
    http_response_code(404);
    exit('Category not found');
}

// Escape output
$category_id   = (int)$row['category_id'];
$category_name = htmlspecialchars($row['category_name'] ?? '', ENT_QUOTES, 'UTF-8');
$category_type = htmlspecialchars($row['category_type'] ?? '', ENT_QUOTES, 'UTF-8');
$description   = htmlspecialchars($row['description'] ?? '', ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-lg p-8 border border-gray-200">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700">Edit Category</h1>
            <p class="text-gray-500 mt-1">Update your category details</p>
        </div>

        <form action="update-category.php" method="post" class="space-y-5">

            <!-- Hidden ID -->
            <input type="hidden" name="C_id" value="<?= $category_id ?>">

            <!-- Category Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
                <input type="text" name="category_name" value="<?= $category_name ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Category Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Category Type</label>
                <select name="category_type" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-indigo-400">

                    <option value="">-- Select Category Type --</option>

                    <optgroup label="🏠 Residential">
                        <option <?= $category_type == 'Apartment / Flat' ? 'selected' : '' ?>>Apartment / Flat</option>
                        <option <?= $category_type == 'House / Villa' ? 'selected' : '' ?>>House / Villa</option>
                        <option <?= $category_type == 'Condominium' ? 'selected' : '' ?>>Condominium</option>
                        <option <?= $category_type == 'Townhouse' ? 'selected' : '' ?>>Townhouse</option>
                    </optgroup>

                    <optgroup label="🏢 Commercial">
                        <option <?= $category_type == 'Office' ? 'selected' : '' ?>>Office</option>
                        <option <?= $category_type == 'Retail / Shop' ? 'selected' : '' ?>>Retail / Shop</option>
                        <option <?= $category_type == 'Restaurant / Cafe' ? 'selected' : '' ?>>Restaurant / Cafe
                        </option>
                    </optgroup>

                    <optgroup label="🌱 Land">
                        <option <?= $category_type == 'Residential Land' ? 'selected' : '' ?>>Residential Land</option>
                        <option <?= $category_type == 'Commercial Land' ? 'selected' : '' ?>>Commercial Land</option>
                    </optgroup>

                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400"><?= $description ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <button type="submit" name="btnupdate"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md">
                    Update Category
                </button>

                <a href="../index.php" class="text-indigo-600 font-medium hover:underline">Back</a>
            </div>

        </form>
    </div>

</body>

</html>