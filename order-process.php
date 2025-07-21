<?php

session_start();
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user name from session
    $user_name = $_SESSION['user_name'] ?? '';

    // Get shipping address and payment method from POST
    $shipping = $_POST['shipping'] ?? [];
    $payment_method = $_POST['payment_method'] ?? '';

    // Prepare address fields
    $full_name = $shipping['full_name'] ?? '';
    $address_line1 = $shipping['address_line1'] ?? '';
    $address_line2 = $shipping['address_line2'] ?? '';
    $city = $shipping['city'] ?? '';
    $state = $shipping['state'] ?? '';
    $pin = $shipping['pin'] ?? ''; // Use 'zip' instead of 'pin'
    $phone = $shipping['phone'] ?? '';
    $items = $_POST['items'] ?? [];

    // Calculate total amount
    $total_amount = 0;
    foreach ($items as $item) {
        $total_amount += floatval($item['price']) * floatval($item['quantity']) * intval($item['count']);
    }

    // Insert into orders table WITH total_amount
    $stmt = $conn->prepare("INSERT INTO orders (user_name, full_name, address_line1, address_line2, city, state, pin, phone, payment_method, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssd", $user_name, $full_name, $address_line1, $address_line2, $city, $state, $pin, $phone, $payment_method, $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the inserted order's ID
    $stmt->close();

    // Insert each item into order_items
    $stmt_item = $conn->prepare("INSERT INTO order_items 
        (order_id, name, price, quantity, count, img) 
        VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($items as $item) {
        $name = $item['name'];
        $price = floatval($item['price']);
        $quantity = floatval($item['quantity']);
        $count = intval($item['count']);
        $img = $item['img'];

        $stmt_item->bind_param("isddis", $order_id, $name, $price, $quantity, $count, $img);
        $stmt_item->execute();
    }

    $stmt_item->close();

    // Redirect or show confirmation
    header("Location: order-success.php?order_id=$order_id");
    exit();
} else {
    echo "Invalid request method.";
}
?>