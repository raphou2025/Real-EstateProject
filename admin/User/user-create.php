<?php
include_once __DIR__ . "/../../config.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
</head>

<body>

    <h2>Add User</h2>

    <form action="user-db.php" method="post" enctype="multipart/form-data">

        <label>Username</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <!-- <label>Profile Picture</label><br>
        <input type="file" name="profile_pic" accept="image/*"><br><br> -->

        <button type="submit" name="submit">Save User</button>

    </form>

</body>

</html>