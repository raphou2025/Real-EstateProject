<?php
// register.php
include("../config.php");
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get inputs safely
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm  = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));

    // Basic validation
    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username exists
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM tbluser WHERE user_name = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $count = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            $error = "Username already taken, please choose another.";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = mysqli_prepare($conn, "INSERT INTO tbluser (user_name, pws) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
            $exec = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($exec) {
                $success = "Registration successful! You can now <a href='login.php' class='text-indigo-600 underline'>login</a>.";
            } else {
                $error = "Error during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-4">
            <img src="../images/logo.png" alt="" class="mx-auto w-20">
            <h1 class="text-2xl font-bold text-indigo-600 mt-2">Register</h1>
            <p class="text-gray-500 text-sm mt-1">Create a new admin account</p>
        </div>

        <?php if($error): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if($success): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
            <?= $success ?>
        </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" id="username" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-1">Confirm
                    Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                Register
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-4">
            Already have an account? <a href="login.php" class="text-indigo-600 underline">Login</a>
        </p>

        <p class="text-center text-yellow-600 text-sm mt-4 font-semibold">&copy; <?= date('Y') ?> ELITE Resident. All
            rights reserved.</p>
    </div>

</body>

</html>