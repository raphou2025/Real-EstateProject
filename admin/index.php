<?php
include_once('../config.php');
include_once('session.php');

/* ===== SUMMARY COUNTS ===== */
function countTable($conn, $sql) {
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        // Debug message (remove later in production)
        die("SQL Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($res);
    return (int)$row['c'];
}


$totalUsers       = countTable($conn, "SELECT COUNT(*) AS c FROM tbluser");
$totalProperties  = countTable($conn, "SELECT COUNT(*) AS c FROM properties");
$availableCount   = countTable($conn, "SELECT COUNT(*) AS c FROM properties WHERE status IN ('Available','For Sale')");
$totalCategories  = countTable($conn, "SELECT COUNT(*) AS c FROM categories");
$totalDetails     = countTable($conn, "SELECT COUNT(*) AS c FROM properties_details");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ELITE Resident-Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Simple DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>

<body class="bg-gray-50 text-gray-800 bg-[url('../images/condonorea.jpg')]">

    <!-- HEADER -->
    <header class="bg-gradient-to-tr from-yellow-200/50 via-pink-400/40 to-indigo-200/40 fixed w-full">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="w-[100px] ml-4">
                <img src="../images/logo.png" alt="">
            </div>
            <!-- <h1 class="text-xl font-bold text-indigo-600">ELITE Resident</h1> -->

            <div class="flex items-center gap-3">
                <input id="globalSearch" type="text" placeholder="Search..."
                    class="border rounded-lg px-3 py-1 focus:ring-indigo-500">
                <div class="relative">
                    <button id="userMenuBtn"
                        class="flex items-center gap-2 p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                        <!-- <i class="fas fa-user-circle text-2xl text-gray-600"></i> -->
                        <img src="../images/꾸리 꾸리.jpg" class="w-[50px] rounded-full" alt="">
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="userDropdown"
                        class="hidden absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border z-50">

                        <div>
                            <a href="../admin/login.php" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>

                            <a href="../admin/register.php" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fas fa-user-plus mr-2"></i> Register
                            </a>

                            <hr>

                            <a href="../admin/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6">

        <!-- STATS -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 mt-[100px]">
            <?php
           $stats = [
             ['Users',$totalUsers,'tbluser','from-indigo-500 to-indigo-600'],
             ['Properties',$totalProperties,'building','from-purple-500 to-purple-600'],
             ['Available',$availableCount,'check-circle','from-emerald-500 to-emerald-600'],
             ['Categories',$totalCategories,'tags','from-orange-500 to-orange-600'],
             ['Details',$totalDetails,'list','from-sky-500 to-sky-600']
           ];
           foreach ($stats as $s):
           ?>
            <div class="rounded-xl p-4 text-white shadow bg-gradient-to-br <?= $s[3] ?>">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm opacity-80"><?= $s[0] ?></p>
                        <p class="text-3xl font-bold"><?= number_format($s[1]) ?></p>
                    </div>
                    <i class="fas fa-<?= $s[2] ?> text-3xl opacity-70"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- TABS -->
        <!-- <div class="flex gap-2 mb-4">
            <button data-tab="properties"
                class="tab-btn bg-gray-500 shadow px-4 py-2 rounded-lg font-semibold">Properties</button>
            <button data-tab="categories" class="tab-btn px-4 py-2 rounded-lg text-white">Categories</button>
            <button data-tab="details" class="tab-btn px-4 py-2 rounded-lg text-white">Property Details</button>
            <button data-tab="users" class="tab-btn px-4 py-2 rounded-lg text-white">Users</button>
        </div> -->

        <div class="flex flex-wrap gap-2 mb-6">

            <!-- Properties (Active by default) -->
            <button data-tab="properties" class="tab-btn px-6 py-2 rounded-lg transition-all duration-200
               bg-white text-yellow-500 shadow-md font-bold">
                Properties
            </button>

            <!-- Categories -->
            <button data-tab="categories" class="tab-btn px-6 py-2 rounded-lg transition-all duration-200
               bg-white/10 text-white font-medium hover:bg-white/30 backdrop-blur-sm">
                Categories
            </button>

            <!-- Property Details -->
            <button data-tab="details" class="tab-btn px-6 py-2 rounded-lg transition-all duration-200
               bg-white/10 text-white font-medium hover:bg-white/30 backdrop-blur-sm">
                Property Details
            </button>

            <!-- Users -->
            <button data-tab="users" class="tab-btn px-6 py-2 rounded-lg transition-all duration-200
               bg-white/10 text-white font-medium hover:bg-white/30 backdrop-blur-sm">
                Users
            </button>

        </div>


        <!-- PROPERTIES -->
        <div id="panel-properties">
            <div class="bg-white/80 rounded-xl shadow border">
                <div class="flex justify-between p-4 border-b">
                    <h2 class="font-bold">Properties</h2>
                    <a href="../admin/Property/add-property(create).php"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                        <i class="fas fa-plus"></i> Add
                    </a>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table id="tblProperties" class="min-w-full text-sm">
                        <thead class="border-b">
                            <tr>
                                <th>ID</th>
                                <th>Property Title</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $sql = "SELECT p.*, c.category_name 
                                     FROM properties p 
                                     LEFT JOIN categories c ON p.category_id=c.category_id 
                                     ORDER BY p.property_id DESC";
                             $res = mysqli_query($conn,$sql);
                             while($row=mysqli_fetch_assoc($res)):
                             ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td><?= $row['property_id'] ?></td>
                                <td><?= htmlspecialchars($row['property_name']) ?></td>
                                <td class="text-emerald-600 font-semibold">$<?= number_format($row['price']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td><?= $row['category_name'] ?? 'Uncategorized' ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>

                                <td>
                                    <?php if($row['img']): ?>
                                    <img src="../assets/images/<?= $row['img'] ?>"
                                        class="w-16 h-10 object-cover rounded">
                                    <?php else: ?>
                                    <span class="text-gray-400">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="flex gap-2 ml-1.5">
                                        <a href="./Property/edit.php?P_id=<?= $row['property_id'] ?>"
                                            class="text-indigo-600"><i class="fas fa-pen"></i></a>
                                        <a href="./Property/delete.php?P_id=<?= $row['property_id'] ?>"
                                            class="text-red-600" onclick="return confirm('Delete this property?')"><i
                                                class="fas fa-trash"></i></a>
                                    </div>

                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div id="panel-categories" class="hidden">
            <div class="bg-white/80 rounded-xl shadow border">
                <!-- Header -->
                <div class="flex justify-between p-4 border-b">
                    <h2 class="font-bold">Categories</h2>
                    <a href="../admin/Category/create-category.php"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                        <i class="fas fa-plus"></i> Add
                    </a>
                </div>

                <!-- Table -->
                <div class="p-4 overflow-x-auto">
                    <table id="tblCategories" class="min-w-full text-sm">
                        <thead class="text-xs uppercase text-gray-600 border-b">
                            <tr>
                                <th class="py-2 px-4">ID</th>
                                <th class="py-2 px-4">Name</th>
                                <th class="py-2 px-4">Type</th>
                                <th class="py-2 px-4">Description</th>
                                <th class="py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php
                    $cats = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_id DESC");
                    while ($c = mysqli_fetch_assoc($cats)):
                        // Optional: check if description column exists
                        $desc = isset($c['Description']) ? htmlspecialchars($c['Description']) : '-';
                    ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4"><?= $c['category_id'] ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($c['category_name']) ?></td>
                                <td class="py-2 px-4"><?= $c['category_type'] ?></td>
                                <td class="py-2 px-4"><?= $desc ?></td>
                                <td>
                                    <div class="flex gap-2 ml-1.5">
                                        <!-- Edit link -->
                                        <a href="../admin/Category/edit-category.php?C_id=<?= $c['category_id'] ?>"
                                            class="text-indigo-600 hover:text-indigo-800">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <!-- Delete link -->
                                        <a href="../admin/Category/delete-category.php?C_id=<?= $c['category_id'] ?>"
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Delete this category?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PROPERTY DETAILS -->
        <div id="panel-details" class="hidden">
            <div class="bg-white/80 rounded-xl shadow border">
                <div class="flex justify-between p-4 border-b">
                    <h2 class="font-bold">Property Details</h2>
                    <a href="Property-Details/create-property_details.php?property_id=5"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"> <i
                            class="fas fa-plus"></i> Add</a>

                </div>

                <div class="p-4 overflow-x-auto">
                    <table id="tblDetails" class="min-w-full text-sm">
                        <thead class="border-b">
                            <tr>
                                <th>ID</th>
                                <th>Property</th>
                                <th>Bedrooms</th>
                                <th>Bathrooms</th>
                                <th>Kitchen</th>
                                <th>Dining</th>
                                <th>Living</th>
                                <th>Size</th>
                                <th>Area</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT d.*, p.property_name
                                    FROM properties_details d
                                    LEFT JOIN properties p ON d.property_id = p.property_id
                                    ORDER BY d.details_id DESC";
                            $res = mysqli_query($conn,$sql);
                            while($row=mysqli_fetch_assoc($res)):
                            ?>
                            <tr>
                                <td><?= $row['details_id'] ?></td>
                                <td><?= htmlspecialchars($row['property_name'] ?? 'Unknown') ?></td>

                                <td><?= $row['bedrooms'] ?></td>
                                <td><?= $row['bathrooms'] ?></td>
                                <td><?= $row['kitchen_rooms'] ?></td>
                                <td><?= $row['dining_rooms'] ?></td>
                                <td><?= $row['living_rooms'] ?></td>
                                <td><?= $row['size'] ?></td>
                                <td><?= $row['area'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td>
                                    <a href="../admin/Property-Details/edit_p-detail.php?details_id=<?= $row['details_id'] ?>"
                                        class="text-indigo-600">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <a href="../admin/Property-Details/delete_p-detail.php?details_id=<?= $row['details_id'] ?>"
                                        onclick="return confirm('Delete this detail?')" class="text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </a>


                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- USERS -->
        <div id="panel-users" class="hidden">
            <div class="bg-white/80 rounded-xl shadow border">
                <div class="flex justify-between p-4 border-b">
                    <h2 class="font-bold">Users</h2>
                    <a href="../admin/User/user-create.php"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table id="tblUsers" class="min-w-full text-sm">
                        <thead class="border-b">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $sql = "SELECT user_id, user_name, email, pws FROM tbluser ORDER BY user_id DESC";
                    $res = mysqli_query($conn, $sql);

                    if (!$res) {
                        die("USER SQL ERROR: " . mysqli_error($conn));
                    }

                    while($row = mysqli_fetch_assoc($res)):
                    ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td><?= $row['user_id'] ?></td>
                                <td><?= htmlspecialchars($row['user_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['email'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['pws'] ?? 'N/A') ?></td>
                                <td>
                                    <div class="flex gap-2 ml-1.5">
                                        <a href="../admin/User/edit-user.php?U_id=<?= $row['user_id'] ?>"
                                            class="text-indigo-600 hover:text-indigo-800">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="../admin/User/delete-user.php?U_id=<?= $row['user_id'] ?>"
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Delete this user?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = {
            properties: document.getElementById('panel-properties'),
            categories: document.getElementById('panel-categories'),
            details: document.getElementById('panel-details'),
            users: document.getElementById('panel-users')
        };

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {
                tabs.forEach(b => b.classList.remove('bg-white', 'shadow', 'font-semibold'));
                btn.classList.add('bg-white', 'shadow', 'font-semibold');

                Object.values(panels).forEach(p => p.classList.add('hidden'));
                panels[btn.dataset.tab].classList.remove('hidden');
            });
        });

        if (document.getElementById('tblProperties')) new simpleDatatables.DataTable('#tblProperties');
        if (document.getElementById('tblCategories')) new simpleDatatables.DataTable('#tblCategories');
        if (document.getElementById('tblDetails')) new simpleDatatables.DataTable('#tblDetails');
        if (document.getElementById('tblUsers')) new simpleDatatables.DataTable('#tblUsers');
    });
    </script> -->

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const tabs = document.querySelectorAll('.tab-btn');

        const panels = {
            properties: document.getElementById('panel-properties'),
            categories: document.getElementById('panel-categories'),
            details: document.getElementById('panel-details'),
            users: document.getElementById('panel-users')
        };

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {

                // Reset all tabs (inactive style)
                tabs.forEach(b => {
                    b.classList.remove(
                        'bg-white',
                        'text-yellow-500',
                        'shadow-md',
                        'font-bold'
                    );

                    b.classList.add(
                        'bg-white/10',
                        'text-white',
                        'font-medium',
                        'hover:bg-white/30',
                        'backdrop-blur-sm'
                    );
                });

                // Active tab (same as Properties)
                btn.classList.remove(
                    'bg-white/10',
                    'text-white',
                    'font-medium',
                    'hover:bg-white/30',
                    'backdrop-blur-sm'
                );

                btn.classList.add(
                    'bg-white',
                    'text-yellow-500',
                    'shadow-md',
                    'font-bold'
                );

                // Hide all panels
                Object.values(panels).forEach(p => {
                    if (p) p.classList.add('hidden');
                });

                // Show selected panel
                panels[btn.dataset.tab].classList.remove('hidden');
            });
        });

        // DataTables (unchanged, just cleaner)
        ['#tblProperties', '#tblCategories', '#tblDetails', '#tblUsers']
        .forEach(id => {
            if (document.querySelector(id)) {
                new simpleDatatables.DataTable(id);
            }
        });

    });
    </script>



    <!-- Dropdown user  -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const userBtn = document.getElementById('userMenuBtn');
        const dropdown = document.getElementById('userDropdown');

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            dropdown.classList.add('hidden');
        });
    });
    </script>




</body>

</html>