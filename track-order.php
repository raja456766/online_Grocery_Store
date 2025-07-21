<?php
session_start();
@include 'dbcon.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

// Check if order_id is provided
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Order ID is required.");
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_name = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("is", $order_id, $user_name);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found or you do not have permission to view this order.");
}

// Fetch order items
$items = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Order - G-Mart</title>
    <link rel="stylesheet" href="index.css">
    <style>
        body { font-family: Arial; margin: 0; background: #f4f4f4; }
        .navbar { background: #2874f0; padding: 10px; text-align: center; color: white; }
        .navbar a { color: white; text-decoration: none; padding: 0 15px; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; }
        .order-details { margin-bottom: 20px; }
        .order-item { display: flex; margin-bottom: 15px; align-items: center; }
        .order-item img { width: 80px; border-radius: 6px; margin-right: 15px; }
        .order-item-details { flex-grow: 1; }
        .order-item-details h4 { margin: 0; font-size: 16px; }
        .status { font-weight: bold; color: green; }
        .cancelled { color: red; }
        .delivery-info { font-size: 14px; color: #555; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="my-orders.php">My Orders</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h1>Track Order #<?= $order['id'] ?></h1>
        <div class="order-details">
            <p><strong>Total:</strong> ₹<?= number_format($order['total_amount'], 2) ?></p>
            <p><strong>Payment:</strong> <?= ucfirst($order['payment_method']) ?></p>
            <p><strong>Status:</strong> <span class="<?= $order['status'] === 'Cancelled' ? 'cancelled' : 'status' ?>"><?= ucfirst($order['status']) ?></span></p>

            <?php
                $deliveryDate = date("d M Y, h:i A", strtotime($order['created_at'] . ' +3 days'));
                if ($order['status'] !== 'Cancelled') {
                    echo "<p class='delivery-info'><strong>Estimated Delivery:</strong> $deliveryDate</p>";
                }
            ?>
        </div>

        <h2>Order Items</h2>
        <?php if ($items->num_rows > 0): ?>
            <?php while ($item = $items->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?= htmlspecialchars($item['img']) ?>" alt="">
                    <div class="order-item-details">
                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                        <p>Price: ₹<?= $item['price'] ?> | Qty: <?= $item['quantity'] ?> | Count: <?= $item['count'] ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
    </div>
</body>
</html>