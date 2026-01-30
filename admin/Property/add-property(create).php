<?php
include_once __DIR__ . "/../../config.php";

// Fetch categories for dropdown
$categories_res = mysqli_query($conn, "SELECT category_id, category_name FROM categories ORDER BY category_name ASC");
if (!$categories_res) die("Database error: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Property</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 p-6 text-white">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-building"></i> Add New Property
            </h1>
        </div>

        <!-- Form -->
        <form action="property-database.php" method="post" enctype="multipart/form-data" class="p-8 space-y-6">

            <!-- Property Title -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Property Title</label>
                <input type="text" name="txtname" required
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Property title e.g. Modern Condo">
            </div>

            <!-- Price & Location -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Price</label>
                    <input type="number" name="txtprice" required
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="e.g. 150000">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="txtlocation" required
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="e.g. Phnom Penh">
                </div>
            </div>

            <!-- Status & Category -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Status</label>
                    <select name="txtstatus"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Available">Available</option>
                        <option value="For Sale">For Sale</option>
                        <option value="For Rent">For Rent</option>
                        <option value="For Lease">For Lease</option>
                        <option value="Under Offer">Under Offer</option>
                        <option value="For Pending">Pending</option>
                        <option value="For Sold">Sold</option>
                        <option value="For Rented">Rented</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category_id" required
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Select Category --</option>
                        <?php while($cat = mysqli_fetch_assoc($categories_res)): ?>
                        <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Property Image</label>
                <input type="file" name="files" accept="image/*" required
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <a href="../index.php"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">Back</a>
                <button type="submit" name="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">Save
                    Property</button>
            </div>

        </form>
    </div>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

</html>