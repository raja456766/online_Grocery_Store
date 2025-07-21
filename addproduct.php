<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$message = '';

// Add Product
if (isset($_POST['add_product'])) {
    $category = $_POST['category'];
    $product_name = $_POST['product_name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $pid = uniqid("PROD"); // Generate unique product ID

    $image_folder = "images/" . $image;

    if (move_uploaded_file($image_tmp, $image_folder)) {
        $sql = "INSERT INTO products (category, pid, pname, stock, image, price) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisd", $category, $pid, $product_name, $stock, $image, $price);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Failed to add product. Try again! Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Failed to upload image.";
    }
}

// Edit Product
if (isset($_POST['edit_product'])) {
    $pid = $_POST['pid'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET price = ?, stock = ? WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dis", $price, $stock, $pid);

    if ($stmt->execute()) {
        $message = "Product updated successfully!";
    } else {
        $message = "Failed to update product. Try again!";
    }
    $stmt->close();
}

// Delete Product
if (isset($_GET['delete'])) {
    $pid = $_GET['delete'];
    $sql = "DELETE FROM products WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pid);

    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Failed to delete product. Try again!";
    }
    $stmt->close();
}

// Fetch Products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Fetch Product for Editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $pid = $_GET['edit'];
    $sql = "SELECT * FROM products WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pid);
    $stmt->execute();
    $edit_product = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Grocery Store Admin</title>
    <link rel="stylesheet" href="admins.css">
    <style>
        /* Reset and Base */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    color: #333;
}

a {
    text-decoration: none;
    color: #3498db;
}

h1 {
    color: #2c3e50;
    text-align: center;
}

/* Layout */
#content {
    padding: 40px;
}

main {
    max-width: 1100px;
    margin: auto;
}

/* Back link */
.back-home {
    display: inline-block;
    margin-bottom: 20px;
    color: #2980b9;
    font-weight: bold;
}

/* Form Section */
.form-container {
    background: #fff;
    padding: 25px 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-bottom: 40px;
}

.form-container h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

input[type="text"],
input[type="number"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    font-size: 16px;
    background: #f9f9f9;
}

button {
    padding: 10px 20px;
    border: none;
    background-color: #27ae60;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

button:hover {
    background-color: #219150;
}

/* Message Styles */
.message {
    margin-top: 20px;
    padding: 10px 15px;
    border-radius: 6px;
    font-weight: bold;
    background-color: #e0f7e9;
    color: #2e7d32;
}

.message.error {
    background-color: #fdecea;
    color: #c0392b;
}

/* Product Table */
#manage-products {
    background: #fff;
    padding: 25px 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    text-align: left;
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
}

th {
    background-color:#3498db;
    font-weight: bold;
}

td img {
    border-radius: 6px;
    max-height: 60px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 10px;
}

.edit-btn, .delete-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
    text-align: center;
    transition: background 0.3s;
}

.edit-btn {
    background-color: #3498db;
    color: white;
}

.edit-btn:hover {
    background-color: #2980b9;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .form-container, #manage-products {
        padding: 15px;
    }

    table, thead, tbody, th, td, tr {
        display: block;
    }

    thead {
        display: none;
    }

    td {
        position: relative;
        padding-left: 50%;
        margin-bottom: 10px;
    }

    td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        top: 12px;
        font-weight: bold;
        color: #666;
    }
}

    </style>
</head>
<body>
    <section id="content">
        <main>
            <a href="adminpage.php" class="back-home">Back to dashboard</a>
            <section id="add-product">
                <div class="form-container">
                    <h1><?= isset($edit_product) ? 'Edit Product' : 'Add Product' ?></h1>
                    <form method="POST" enctype="multipart/form-data">
                        <?php if (isset($edit_product)): ?>
                            <input type="hidden" name="pid" value="<?= $edit_product['pid'] ?>">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" id="price" required step="0.01" placeholder="Enter product price" value="<?= $edit_product['price'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" required placeholder="Enter available stock quantity" value="<?= $edit_product['stock'] ?>">
                            </div>
                            <button type="submit" name="edit_product">Update Product</button>
                        <?php else: ?>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" name="category" id="category" required placeholder="Enter product category">
                            </div>

                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" name="product_name" id="product_name" required placeholder="Enter product name">
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" required placeholder="Enter available stock quantity">
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" id="price" required step="0.01" placeholder="Enter product price">
                            </div>

                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <input type="file" name="image" id="image" accept="image/*" required>
                            </div>

                            <button type="submit" name="add_product">Add Product</button>
                        <?php endif; ?>
                    </form>

                    <?php if (isset($message)) echo "<p class='message " . (strpos($message, 'successfully') !== false ? '' : 'error') . "'>$message</p>"; ?>
                </div>
            </section>

            <section id="manage-products">
                <h1>Manage Products</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['pid']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['pname']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td>₹<?php echo $row['price']; ?></td>
                            <td><img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['pname']; ?>" width="50"></td>
                            <td class="action-buttons">
                                <a href="addproduct.php?edit=<?php echo $row['pid']; ?>" class="edit-btn">Edit</a>
                                <a href="addproduct.php?delete=<?php echo $row['pid']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </section>
</body>
</html>