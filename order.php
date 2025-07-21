<?php
session_start();


// Initialize array
$order_items = [];

// Buy Now: Handle single product
if (
    isset($_GET['name'], $_GET['price'], $_GET['img'], $_GET['quantity'], $_GET['unit'])
) {
    $order_items[] = [
        'name'     => urldecode($_GET['name']),
        'price'    => floatval($_GET['price']),
        'img'      => urldecode($_GET['img']),
        'quantity' => floatval($_GET['quantity']),
        'unit'     => $_GET['unit'],
        'count'    => isset($_GET['count']) ? intval($_GET['count']) : 1
    ];
}

// Checkout: Handle multiple items from cart
if (isset($_GET['items']) && is_array($_GET['items'])) {
    foreach ($_GET['items'] as $item_json) {
        $item = json_decode(urldecode($item_json), true);
        if ($item && isset($item['name'], $item['price'], $item['img'], $item['quantity'])) {
            $order_items[] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order - G-Mart</title>
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1 class="heading">Order <span>Confirmation</span></h1>

        <?php if (!empty($order_items)): ?>
            <div class="order-details">
                <?php 
                $total = 0;
                foreach ($order_items as $item): 
                    $item_total = $item['price'] * $item['quantity'] * $item['count'];
                    $total += $item_total;
                ?>
                    <div class="order-item">
                        <img src="<?= htmlspecialchars($item['img']) ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>" 
                             style="max-width: 100px; border-radius: 5px;">
                        <div class="item-details">
                            <h2><?= htmlspecialchars($item['name']) ?></h2>
                            <p>Unit Price: ₹<?= number_format($item['price'], 2) ?></p>
                            <p>Quantity: <?= htmlspecialchars($item['quantity']) ?> <?= htmlspecialchars($item['unit'] ?? '') ?></p>
                            <p>Count: <?= htmlspecialchars($item['count']) ?></p>
                            <p>Subtotal: ₹<?= number_format($item_total, 2) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="order-total">
                    <h3>Total: ₹<?= number_format($total, 2) ?></h3>
                </div>

               <form action="address.php" method="POST">
    <!-- Hidden inputs for each order item -->
    <?php foreach ($order_items as $index => $item): ?>
        <input type="hidden" name="items[<?= $index ?>][name]" value="<?= htmlspecialchars($item['name']) ?>">
        <input type="hidden" name="items[<?= $index ?>][price]" value="<?= htmlspecialchars($item['price']) ?>">
        <input type="hidden" name="items[<?= $index ?>][img]" value="<?= htmlspecialchars($item['img']) ?>">
        <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= htmlspecialchars($item['quantity']) ?>">
        <input type="hidden" name="items[<?= $index ?>][unit]" value="<?= htmlspecialchars($item['unit'] ?? '') ?>">
        <input type="hidden" name="items[<?= $index ?>][count]" value="<?= htmlspecialchars($item['count']) ?>">
    <?php endforeach; ?>

    <button type="submit" class="btn">Add Address</button>
</form>

        <?php else: ?>
            <p>No items selected for purchase.</p>
            <p>Debug Info: <?= htmlspecialchars(json_encode($_GET)) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
