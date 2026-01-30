<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property List</title>
</head>

<body>

    <h2>Property List</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Photo</th>
            <th>Price</th>
            <th>Location</th>
            <th>Status</th>
            <th>Category</th>
        </tr>

        <?php
        include_once('../config.php');

        // Fetch properties with category name
        $sql = "SELECT p.property_id, p.property_name, p.price, p.location, p.status, p.img, c.category_name
                FROM properties p
                 JOIN categories c ON p.category_id = c.category_id";

        $retval = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($retval)) {
            echo "<tr>";
            echo "<td>".$row['property_id']."</td>";
            echo "<td>".$row['property_name']."</td>";
            
            // Show image safely
            if(!empty($row['img'])){
                echo "<td><img src='../assets/images/".$row['img']."' width='100' /></td>";
            } else {
                echo "<td>No Image</td>";
            }
            
            echo "<td>".$row['price']."</td>";
            echo "<td>".$row['location']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "<td>".$row['category_name']."</td>";
            echo "</tr>";
        }

        mysqli_close($conn);
        ?>

    </table>

</body>

</html>