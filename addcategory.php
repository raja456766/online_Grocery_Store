<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "groceryweb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $sql = "INSERT INTO products (name, price, description) VALUES ('$name', '$price', '$description')";
    $conn->query($sql);
}

// Fetch Products
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; }
        form { display: flex; flex-direction: column; }
        input, textarea, button { margin: 10px 0; padding: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit">Add Product</button>
        </form>

        <h2>Products</h2>
        <ul>
            <?php while ($row = $products->fetch_assoc()): ?>
                <li>
                    <h3><?php echo $row["name"]; ?></h3>
                    <p>Price: $<?php echo $row["price"]; ?></p>
                    <p><?php echo $row["description"]; ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
