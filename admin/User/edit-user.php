<?php
include_once __DIR__ . "/../../config.php";
// include_once('session.php'); // Uncomment if using login/session

if (!isset($_GET['U_id']) || empty($_GET['U_id'])) {
    die("User ID is missing.");
}

$user_id = intval($_GET['U_id']);

$sql = "SELECT user_name, email, pws FROM tbluser WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_name = $_POST['user_name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $pws       = $_POST['pws'] ?? '';

    $update_sql = "UPDATE tbluser SET user_name = ?, email = ?, pws = ? WHERE user_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "sssi", $user_name, $email, $pws, $user_id);

    if (mysqli_stmt_execute($update_stmt)) {
        $success = "User updated successfully.";
        $user['user_name'] = $user_name;
        $user['email'] = $email;
        $user['pws'] = $pws;
    } else {
        $error = "Failed to update user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-gray-200">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-600 mb-1">Edit User</h1>
            <p class="text-gray-500">Update user information below</p>
        </div>

        <?php if (!empty($success)): ?>
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded-lg border border-green-200 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> <?= $success ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-800 p-3 mb-4 rounded-lg border border-red-200 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label class="block mb-2 font-semibold text-gray-700">Name</label>
                <input type="text" name="user_name" value="<?= htmlspecialchars($user['user_name']) ?>" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">Password</label>
                <input type="text" name="pws" value="<?= htmlspecialchars($user['pws']) ?>" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="../../admin/index.php"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 rounded-xl font-semibold transition">Back</a>
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

</html>