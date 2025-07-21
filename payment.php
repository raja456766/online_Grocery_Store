<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store shipping address in session
    $_SESSION['shipping'] = $_POST;
}
$order_items = $_SESSION['order_items'] ?? [];
$shipping = $_SESSION['shipping'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Method - G-Mart</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div style="text-align: center; margin: 20px 0;">
        <img src="images/logo.jpeg" alt="G-Mart Logo" style="max-height: 80px;">
    </div>

    <div class="container">
        <h1>Payment & Confirmation</h1>

        <!-- Show shipping address summary -->
        <?php if (!empty($shipping)): ?>
            <div class="address-summary" style="background:#f9f9f9; padding:15px; border-radius:8px; margin-bottom:20px;">
                <h3>Shipping Address</h3>
                <p>
                    <?= htmlspecialchars($shipping['full_name'] ?? '') ?><br>
                    <?= htmlspecialchars($shipping['address_line1'] ?? '') ?><br>
                    <?= htmlspecialchars($shipping['address_line2'] ?? '') ?><br>
                    <?= htmlspecialchars($shipping['city'] ?? '') ?>, <?= htmlspecialchars($shipping['state'] ?? '') ?><br>
                    PIN: <?= htmlspecialchars($shipping['zip'] ?? '') ?><br>
                    Phone: +91<?= htmlspecialchars($shipping['phone'] ?? '') ?>
                </p>
            </div>
        <?php endif; ?>

        <form action="order-process.php" method="POST">
            <h3>Select Payment Method:</h3>
            <div class="payment-option">
                <input type="radio" id="cod" name="payment_method" value="cod" required>
                <label for="cod">Cash on Delivery</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="online" name="payment_method" value="online">
                <label for="online">Online Payment</label>
            </div>

            <?php foreach ($order_items as $index => $item): ?>
                <input type="hidden" name="items[<?= $index ?>][name]" value="<?= htmlspecialchars($item['name']) ?>">
                <input type="hidden" name="items[<?= $index ?>][price]" value="<?= htmlspecialchars($item['price']) ?>">
                <input type="hidden" name="items[<?= $index ?>][img]" value="<?= htmlspecialchars($item['img']) ?>">
                <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= htmlspecialchars($item['quantity']) ?>">
                <input type="hidden" name="items[<?= $index ?>][unit]" value="<?= htmlspecialchars($item['unit'] ?? '') ?>">
                <input type="hidden" name="items[<?= $index ?>][count]" value="<?= htmlspecialchars($item['count']) ?>">
            <?php endforeach; ?>

            <!-- Pass shipping address to order-process.php -->
            <?php foreach ($shipping as $key => $value): ?>
                <input type="hidden" name="shipping[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>

            <button type="submit" class="btn">Confirm Order</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const onlinePayment = document.getElementById('online');
            const codPayment = document.getElementById('cod');

            onlinePayment.addEventListener('click', function (e) {
                alert("Online payment is not available at this time. Please select Cash on Delivery.");
                e.preventDefault();
                codPayment.checked = true;
            });
        });
    </script>
</body>
</html>