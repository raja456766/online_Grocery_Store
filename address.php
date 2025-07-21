<?php
session_start();

// Store the order items in session from previous page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['order_items'] = $_POST['items'] ?? [];
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_name'])) {
    $_SESSION['message'] = 'Please login to continue to address entry.';
    $_SESSION['redirect_after_login'] = 'address.php';
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Shipping Address - G-Mart</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div style="text-align: center; margin: 20px 0;">
    <img src="images/logo.jpeg" alt="G-Mart Logo" style="max-height: 80px;">
</div>

<div class="container">
    <h1>Shipping Address</h1>
    <form action="payment.php" method="POST">
        <div class="address-field">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="address-field">
            <label>Address Line 1</label>
            <input type="text" name="address_line1" required>
        </div>
        <div class="address-field">
            <label>Address Line 2 (optional)</label>
            <input type="text" name="address_line2">
        </div>
        <div class="address-field">
            <label>City</label>
            <input type="text" name="city" required>
        </div>
        <div class="address-field">
            <label>State</label>
            <input type="text" name="state" required>
        </div>
        <div class="address-field">
            <label>PIN Code</label>
            <input type="text" name="zip" required pattern="^(?!([0-9])\1{5})[0-9]{6}$">
        </div>
        <div class="address-field">
            <label>Phone Number</label>
            <div style="display: flex;">
                <span style="padding: 5px; background-color: #f0f0f0; border: 1px solid #ccc; border-right: none;">+91</span>
                <input type="tel" name="phone" required pattern="^(?!([6-9])\1{9})[6-9][0-9]{9}$" style="flex: 1; border-left: none;">
            </div>
        </div>
        <button type="submit" class="btn">Next</button>
    </form>
</div>
</body>
</html>
