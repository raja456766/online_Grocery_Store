<?php
session_start();
@include 'dbcon.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$actionMessage = '';

// Handle cancel or delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel_order_id'])) {
        $cancel_id = intval($_POST['cancel_order_id']);
        $conn->query("UPDATE orders SET status = 'Cancelled' WHERE id = $cancel_id AND user_name = '$user_name'");
        header("Location: my-orders.php?action=cancelled");
        exit();
    } elseif (isset($_POST['delete_order_id'])) {
        $delete_id = intval($_POST['delete_order_id']);
        $conn->query("DELETE FROM order_items WHERE order_id = $delete_id");
        $conn->query("DELETE FROM orders WHERE id = $delete_id AND user_name = '$user_name'");
        header("Location: my-orders.php?action=deleted");
        exit();
    }
}

// Fetch orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_name = ? ORDER BY id DESC");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $user_name);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - G-Mart</title>
    <link rel="stylesheet" href="index.css">
    <style>
        body { font-family: Arial; margin: 0; background: #f4f4f4; }
        .navbar { background:green; padding: 10px; text-align: center; color: white; }
        .navbar a { color: white; text-decoration: none; padding: 0 15px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; }
        .order-card { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .order-item { display: flex; margin-bottom: 15px; align-items: center; }
        .order-item img { width: 80px; border-radius: 6px; margin-right: 15px; }
        .order-item-details { flex-grow: 1; }
        .order-item-details h4 { margin: 0; font-size: 16px; }
        .status { font-weight: bold; color: green; }
        .cancelled { color: red; }
        .btn { padding: 8px 12px; border: none; border-radius: 5px; margin: 5px; cursor: pointer; }
        .btn-cancel { background: #ff9800; color: white; }
        .btn-delete { background: #f44336; color: white; }
        .btn-disabled { background: #ccc; cursor: not-allowed; }
        .delivery-info { font-size: 14px; color: #555; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="product.php">Products</a>
    </div>

    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($user_name) ?>!</h1>
        <h2>Your Orders</h2>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <div class="order-card">
                    <h3>Order #<?= $order['id'] ?> <?= $order['status'] === 'Cancelled' ? '<span class="cancelled">(Cancelled)</span>' : '' ?></h3>
                    <?php
                        // If total_amount is missing or zero, calculate it from order_items
                        $total_amount = $order['total_amount'];
                        if ($total_amount == 0 || $total_amount == null) {
                            $total_amount = 0;
                            $items_for_total = $conn->query("SELECT price, quantity, count FROM order_items WHERE order_id = {$order['id']}");
                            while ($it = $items_for_total->fetch_assoc()) {
                                $total_amount += floatval($it['price']) * floatval($it['quantity']) * intval($it['count']);
                            }
                        }
                    ?>
                    <p><strong>Total:</strong> ₹<?= number_format($total_amount, 2) ?></p>
                    <p><strong>Payment:</strong> <?= ucfirst($order['payment_method']) ?></p>
                    <p><strong>Status:</strong> <span class="status"><?= ucfirst($order['status']) ?></span></p>

                    <?php
                        $deliveryDate = date("d M Y, h:i A", strtotime($order['created_at'] . ' +3 days'));
                        if ($order['status'] !== 'Cancelled') {
                            echo "<p class='delivery-info'><strong>Estimated Delivery:</strong> $deliveryDate</p>";
                        }
                    ?>

                    <!-- Fetch items -->
                    <?php
                        $items = $conn->query("SELECT * FROM order_items WHERE order_id = {$order['id']}");
                        while ($item = $items->fetch_assoc()):
                    ?>
                        <div class="order-item">
                            <img src="<?= htmlspecialchars($item['img']) ?>" alt="">
                            <div class="order-item-details">
                                <h4><?= htmlspecialchars($item['name']) ?></h4>
                                <p>Price: ₹<?= $item['price'] ?> | Qty: <?= $item['quantity'] ?> | Count: <?= $item['count'] ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <!-- Action Buttons -->
                    <form method="POST">
                        <?php if ($order['status'] !== 'Cancelled'): ?>
                            <button class="btn btn-cancel" type="submit" name="cancel_order_id" value="<?= $order['id'] ?>">Cancel</button>
                        <?php else: ?>
                            <button class="btn btn-cancel btn-disabled" disabled>Cancelled</button>
                        <?php endif; ?>
                        <button class="btn btn-delete" type="submit" name="delete_order_id" value="<?= $order['id'] ?>">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No orders yet. <a href="index.php">Start Shopping</a></p>
        <?php endif; ?>
    </div>

    <!-- Alert Script -->
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get("action");
        if (action === "cancelled") {
            alert("Your order has been cancelled successfully.");
        } else if (action === "deleted") {
            alert("Your order has been deleted.");
        }
    </script>
</body>
</html>