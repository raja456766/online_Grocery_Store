<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}


// Dashboard counts
$user_count = $order_count = $stock_count = 0;

// Fetching counts from the database
$user_result = $conn->query("SELECT COUNT(*) AS total FROM users");
if ($user_result) {
    $user_count = $user_result->fetch_assoc()['total'];
}

// Count total orders (not order_items)
$order_result = $conn->query("SELECT COUNT(*) AS total FROM orders");
if ($order_result) {
    $order_count = $order_result->fetch_assoc()['total'];
}

$stock_result = $conn->query("SELECT SUM(stock) AS total FROM products");
if ($stock_result) {
    $stock_count = $stock_result->fetch_assoc()['total'];
}

// Add product handling
if (isset($_POST['add_product'])) {
    $category = $_POST['category'];
    $product_name = $_POST['product_name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "uploads/" . $image;

    // Move the uploaded image to the folder
    move_uploaded_file($image_tmp, $image_folder);

    // Insert product into the database
    $sql = "INSERT INTO products (category, pname, stock, image, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $category, $product_name, $stock, $image, $price);
    $stmt->execute();
    $stmt->close();
    header('Location: adminpage.php'); // Refresh the page
    exit();
}

// Handle deleting product
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $conn->query("DELETE FROM products WHERE id = $product_id");
    header('Location: adminpage.php');
    exit();
}

// Handle category addition
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $conn->query("INSERT INTO categories (name) VALUES ('$category_name')");
    header('Location: adminpage.php');
    exit();
}

// Handle user search
$searched_user = null;
$user_orders = [];
if (isset($_GET['search_user']) && !empty($_GET['search_user'])) {
    $search_name = $conn->real_escape_string($_GET['search_user']);
    // Use the correct column name for username (likely 'user_name')
    $user_sql = "SELECT * FROM users WHERE name LIKE '%$search_name%'";
    $user_res = $conn->query($user_sql);
    if ($user_res && $user_res->num_rows > 0) {
       $searched_users = []; // array of users with their orders

while ($user = $user_res->fetch_assoc()) {
    $uid = $user['id'];
    $orders_sql = "SELECT * FROM orders WHERE user_id = $uid";
    $orders_res = $conn->query($orders_sql);
    $orders = [];
    while ($order = $orders_res->fetch_assoc()) {
        $orders[] = $order;
    }
    $searched_users[] = [
        'user' => $user,
        'orders' => $orders
    ];
}

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="admins.css">
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="index.php" class="brand">
            <i class='bx bxs-cart'></i>
            <span class="text">G-martAdmin</span>
        </a>
        <ul class="side-menu top">
            <li class="active"><a href="#dashboard"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
             <li><a href="addproduct.php"><i class='bx bxs-package'></i><span class="text">Products</span></a></li>
            <li><a href="users.php"><i class='bx bxs-user'></i><span class="text">Users</span></a></li>
            <li><a href="view_orders.php"><i class='bx bxs-truck'></i><span class="text">Orders</span></a></li>
        </ul>
        <ul class="side-menu">
            <li><a href="logout.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>

    <!-- CONTENT -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <form action="" id="search-form" method="get">
                <div class="form-input">
                    <input type="search" name="search_user" placeholder="Search user by name..." value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
        </nav>

        <main>
              <!-- User Search Results -->
           <?php if (!empty($searched_users)): ?>
    <section class="content-section">
        <div class="head-title"><h2>User Search Results</h2></div>
        <?php foreach ($searched_users as $entry): ?>
            <?php $user = $entry['user']; $orders = $entry['orders']; ?>
            <ul style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc;">
                <li><strong>ID:</strong> <?= $user['id']; ?></li>
                <li><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></li>
            </ul>

            <h3>Orders for <?= htmlspecialchars($user['name']) ?>:</h3>
            <?php if (!empty($orders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['order_date'] ?></td>
                                <td><?= $order['status'] ?></td>
                                <td><?= $order['total'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders found for this user.</p>
            <?php endif; ?>
            <hr>
        <?php endforeach; ?>
    </section>
<?php elseif (isset($_GET['search_user'])): ?>
    <section class="content-section">
        <p>No user found with that name.</p>
    </section>
<?php endif; ?>

            <!-- Dashboard Section -->
           <!-- Dashboard Section -->
<section id="dashboard" class="content-section active">

                <div class="head-title">
                    <h1>Dashboard</h1>
                </div>
                <ul class="box-info">
                    <li><i class='bx bxs-user'></i><span class="text"><h3><?= $user_count ?></h3><p>User Logins</p></span></li>
                    <li><i class='bx bxs-cart-add'></i><span class="text"><h3><?= $order_count ?></h3><p>Total Orders</p></span></li>
                    <li><i class='bx bxs-package'></i><span class="text"><h3><?= $stock_count ?></h3><p>Stock Items</p></span></li>
                </ul>
            </section>

            <!-- Add Category Section -->
            <section id="inventory" class="content-section">
                <div class="head-title">
                    <h1>Add Category</h1>
                </div>
                <form method="POST">
                    <input type="text" name="category_name" placeholder="Category Name" required>
                    <button type="submit" name="add_category">Add Category</button>
                </form>
            </section>

            <!-- Products Section -->
            <section id="products" class="content-section">
                <div class="head-title">
                    <h1>Product Management</h1>
                    <button class="btn-add" onclick="showAddForm('product')"><i class='bx bx-plus'></i> Add Product</button>
                </div>
                <table>
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Stock</th><th>Price</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch products from the database
                        $res = $conn->query("SELECT id, pname, stock, price FROM products");
                        while ($row = $res->fetch_assoc()) {
                            echo "<tr><td>{$row['id']}</td><td>{$row['pname']}</td><td>{$row['stock']}</td><td>{$row['price']}</td><td><a href='?delete_product={$row['id']}'>Delete</a></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Modal for Adding Product -->
            <div id="form-modal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeForm()">&times;</span>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="product">
                        <input type="text" name="category" placeholder="Category" required>
                        <input type="text" name="product_name" placeholder="Product Name" required>
                        <input type="number" name="stock" placeholder="Stock" required>
                        <input type="number" name="price" placeholder="Price" required>
                        <input type="file" name="image" required>
                        <button type="submit" name="add_product">Save Product</button>
                    </form>
                </div>
            </div>
        </main>
    </section>

    <script src="admin.js"></script>
</body>
</html>

<?php $conn->close(); ?>
