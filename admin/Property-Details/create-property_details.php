<?php
include_once __DIR__ . "/../../config.php";

// Fetch all properties to populate the dropdown
$properties_res = mysqli_query($conn, "SELECT property_id, property_name FROM properties ORDER BY property_name ASC");

if (!$properties_res) {
    die("Database error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Property Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 p-8">

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow">
        <div class="bg-green-600 text-white p-6 rounded-t-xl">
            <h1 class="text-xl font-bold">
                Add Property Details
            </h1>
        </div>

        <form action="p-details_db.php" method="POST" class="p-8 space-y-6">

            <!-- Property Dropdown -->
            <div>
                <label class="font-bold">Select Property</label>
                <select name="property_id" required class="w-full border p-3 rounded">
                    <option value="">-- Select Property --</option>
                    <?php while($prop = mysqli_fetch_assoc($properties_res)): ?>
                    <option value="<?= $prop['property_id'] ?>"><?= htmlspecialchars($prop['property_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Size & Area -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="font-bold">Size</label>
                    <input type="text" name="size" required class="w-full border p-3 rounded">
                </div>
                <div>
                    <label class="font-bold">Area</label>
                    <input type="text" name="area" required class="w-full border p-3 rounded">
                </div>
            </div>

            <!-- Rooms -->
            <div class="grid grid-cols-5 gap-3">
                <?php
            $rooms = [
                'bedrooms' => 'Beds',
                'bathrooms' => 'Baths',
                'kitchen_rooms' => 'Kitchen',
                'dining_rooms' => 'Dining',
                'living_rooms' => 'Living'
            ];
            foreach ($rooms as $name => $label):
            ?>
                <div>
                    <label class="text-xs font-bold"><?= $label ?></label>
                    <input type="number" name="<?= $name ?>" value="0" min="0" class="w-full border p-2 rounded">
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Description -->
            <div>
                <label class="font-bold">Description</label>
                <textarea name="description" required class="w-full border p-3 rounded"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="../../admin/index.php" class="text-gray-400">Cancel</a>
                <button type="submit" name="create" class="bg-green-600 text-white px-6 py-3 rounded font-bold">
                    Save Details
                </button>
            </div>
        </form>
    </div>

</body>

</html>