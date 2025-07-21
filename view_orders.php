<?php

session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle "Delete All Orders" action
if (isset($_POST['delete_all_orders'])) {
    $conn->query("DELETE FROM `order_items`");
    $conn->query("DELETE FROM `orders`");
    header("Location: view_orders.php");
    exit();
}

// SQL Query to fetch order details along with order items
$sql = "
    SELECT 
        o.user_id AS order_id,
        o.user_name,
        o.full_name,
        o.address_line1,
        o.address_line2,
        o.city,
        o.state,
        o.pin,
        o.phone,
        o.payment_method,
        o.total_amount,
        o.created_at,
        o.status,
        oi.id AS item_id,
        oi.name AS item_name,
        oi.price AS item_price,
        oi.quantity AS item_quantity,
        oi.count AS item_count,
        oi.img AS item_img
    FROM `orders` o
    LEFT JOIN `order_items` oi ON o.user_id = oi.order_id
    ORDER BY o.created_at DESC, oi.id ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .home-button, .delete-all-button {
            text-align: right;
            margin-bottom: 20px;
        }
        .home-button a, .delete-all-button button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .home-button a:hover, .delete-all-button button:hover {
            background-color: #45a049;
        }
        .order-item {
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .order-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
        }
        .order-item div {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="home-button">
            <a href="adminpage.php"> Back to dashboard</a>
        </div>
        <div class="delete-all-button">
            <form method="POST">
                <button type="submit" name="delete_all_orders" onclick="return confirm('Are you sure you want to delete all orders?');">Delete All Orders</button>
            </form>
        </div>
        <h1>Order Details</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City/State</th>
                    <th>Pin</th>
                    <th>Phone</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Delivery At (5 Days Later)</th>
                    <th>Order Items</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0):
                    $current_order_id = null;
                    while($row = $result->fetch_assoc()):
                        $delivery_date = date('Y-m-d', strtotime($row['created_at'] . ' +5 days'));
                        // New order row
                        if ($row['order_id'] != $current_order_id):
                            if ($current_order_id !== null) echo "</td></tr>";
                            echo "<tr>
                                <td>{$row['order_id']}</td>
                                <td>" . htmlspecialchars($row['user_name']) . "</td>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td>" . htmlspecialchars($row['address_line1']) . " " . htmlspecialchars($row['address_line2']) . "</td>
                                <td>" . htmlspecialchars($row['city']) . ", " . htmlspecialchars($row['state']) . "</td>
                                <td>" . htmlspecialchars($row['pin']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['payment_method']) . "</td>
                                <td>₹" . number_format($row['total_amount'], 2) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                                <td>{$delivery_date}</td>
                                <td>";
                        endif;
                        // Order item details
                        if ($row['item_id'] !== null) {
                            echo "<div class='order-item'><img src='" . htmlspecialchars($row['item_img']) . "' alt='" . htmlspecialchars($row['item_name']) . "'>
                            <div>
                                <strong>" . htmlspecialchars($row['item_name']) . "</strong>
                                | Price: ₹" . number_format($row['item_price'], 2) . "
                                | Qty: " . htmlspecialchars($row['item_quantity']) . "
                                | Count: " . htmlspecialchars($row['item_count']) . "
                            </div></div>";
                        }
                        $current_order_id = $row['order_id'];
                    endwhile;
                    echo "</td></tr>"; // Close last order row
                else:
                    echo "<tr><td colspan='13' style='text-align:center;'>No orders found.</td></tr>";
                endif;
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>