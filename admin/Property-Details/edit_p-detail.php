<?php
include_once __DIR__ . "/../../config.php";

$details_id = isset($_GET['details_id']) ? (int)$_GET['details_id'] : 0;

$sql = "
SELECT 
    pd.*, 
    p.property_name 
FROM properties_details pd
JOIN properties p ON pd.property_id = p.property_id
WHERE pd.details_id = $details_id
";

$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) === 0) {
    die("Details not found.");
}

$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Property Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 p-8">

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow">
        <div class="bg-blue-600 text-white p-6 rounded-t-xl">
            <h1 class="text-xl font-bold">
                Edit Details: <?= htmlspecialchars($data['property_name']) ?>
            </h1>
        </div>

        <form action="update_p-detail.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="details_id" value="<?= $data['details_id'] ?>">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="font-bold">Size</label>
                    <input type="text" name="size" value="<?= htmlspecialchars($data['size']) ?>" required
                        class="w-full border p-3 rounded">
                </div>
                <div>
                    <label class="font-bold">Area</label>
                    <input type="text" name="area" value="<?= htmlspecialchars($data['area']) ?>" required
                        class="w-full border p-3 rounded">
                </div>
            </div>

            <div class="grid grid-cols-5 gap-3">
                <?php foreach (['bedrooms','bathrooms','kitchen_rooms','dining_rooms','living_rooms'] as $f): ?>
                <div>
                    <label class="text-xs font-bold"><?= ucfirst(str_replace('_',' ',$f)) ?></label>
                    <input type="number" name="<?= $f ?>" value="<?= $data[$f] ?>" class="w-full border p-2 rounded">
                </div>
                <?php endforeach; ?>
            </div>

            <div>
                <label class="font-bold">Description</label>
                <textarea name="description" required
                    class="w-full border p-3 rounded"><?= htmlspecialchars($data['description']) ?></textarea>
            </div>

            <div class="flex justify-between">
                <a href="../../admin/index.php?tab=details" class="text-gray-400">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded font-bold">
                    Update Details
                </button>
            </div>
        </form>
    </div>

</body>

</html>