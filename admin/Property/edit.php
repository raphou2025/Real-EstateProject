<?php
include_once __DIR__ . "/../../config.php";

// Get property ID from URL
$id = isset($_GET['P_id']) ? (int)$_GET['P_id'] : 0;

$sql = "SELECT * FROM properties WHERE property_id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: linear-gradient(135deg, #f0f4ff 0%, #d9e2ff 100%);
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6366f1;
    }

    .input-field {
        padding-left: 3rem;
    }

    #imgPreview {
        max-width: 300px;
        max-height: 220px;
        border-radius: 1rem;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-gradient {
        background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
    }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-8 relative overflow-hidden">

        <!-- Header Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-200 to-purple-200 opacity-20 rounded-3xl -z-10"></div>

        <h1 class="text-4xl font-bold text-indigo-700 mb-2 flex items-center">
            <i class="fas fa-building mr-3"></i>
            Edit Property
        </h1>
        <p class="text-gray-600 mb-8">Update all details of your property in one place</p>

        <form action="update_property.php" method="post" enctype="multipart/form-data" class="space-y-6">

            <!-- Hidden fields -->
            <input type="hidden" name="P_id" value="<?= $row['property_id'] ?>">
            <input type="hidden" name="old_img" value="<?= $row['img'] ?>">

            <!-- Property Name -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Property Name <span
                        class="text-red-500">*</span></label>

                <input type="text" name="txtname" value="<?= htmlspecialchars($row['property_name']) ?>" required
                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 outline-none transition duration-200">
            </div>

            <!-- Property Image -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Property Picture</label>
                <input type="file" name="files" accept="image/*" onchange="previewImage(event)"
                    class="w-full text-gray-700 border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                <div class="mt-4 flex justify-center">
                    <img id="imgPreview" src="../assets/images/<?= $row['img'] ?>" alt="Property-Image">
                </div>
            </div>

            <!-- Price -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                <input type="text" name="txtprice" value="<?= htmlspecialchars($row['price']) ?>" required
                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 outline-none transition duration-200">
            </div>

            <!-- Location -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Location <span
                        class="text-red-500">*</span></label>
                <input type="text" name="txtlocation" value="<?= htmlspecialchars($row['location']) ?>" required
                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 outline-none transition duration-200">
            </div>

            <!-- Status -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                <select name="txtstatus" required
                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 outline-none transition duration-200">
                    <?php
                // All possible statuses
                $statuses = [
                    'Available', 'For Sale', 'For Rent', 'For Lease', 
                    'Under Offer', 'Pending', 'Sold', 'Rented'
                ];
        
                // $row['status'] should contain the current status if editing, otherwise it's empty
                foreach ($statuses as $status):
                    $selected = (isset($row['status']) && $row['status'] === $status) ? 'selected' : '';
                ?>
                    <option value="<?= $status ?>" <?= $selected ?>><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <!-- Category -->
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-2">Category Name<span
                        class="text-red-500">*</span></label>
                <select name="category_id" required
                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 outline-none transition duration-200">
                    <?php
                    $cat_sql = "SELECT * FROM categories";
                    $cat_result = mysqli_query($conn, $cat_sql);
                    while($cat = mysqli_fetch_assoc($cat_result)){
                        $selected = ($cat['category_id'] == $row['category_id']) ? "selected" : "";
                        echo "<option value='".$cat['category_id']."' $selected>".htmlspecialchars($cat['category_name'])."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <a href="index.php"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition shadow-sm">Back</a>
                <button type="submit" name="btnupdate"
                    class="px-6 py-3 btn-gradient text-white rounded-xl font-semibold hover:shadow-lg shadow-md transition flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Update Property
                </button>
            </div>

        </form>
    </div>

    <script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('imgPreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>
</body>

</html>