<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the order ID from the URL
$order_id = $_GET['id'] ?? null;

if (!$order_id) {
    echo "Invalid order ID.";
    exit;
}

// Fetch order details along with address information
$stmt = $db_connection->prepare("
    SELECT o.order_date, o.total_price_alv, o.delivery_method, o.address, o.city, o.state, o.zipcode, o.country
    FROM orders o
    WHERE o.id = ? AND o.customer_id = ?
");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found or you do not have permission to view this order.";
    exit;
}

// Fetch order items with product names
$items_stmt = $db_connection->prepare("
    SELECT oi.quantity, oi.price_alv, p.name, p.id as product_id
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$items_stmt->execute([$order_id]);
$order_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white mt-8 max-w-4xl rounded-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Order Details</h2>
        <a href="my_orders.php" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Orders
        </a>
    </div>

    <div class="p-4 border rounded-lg mb-4">
        <h3 class="text-xl font-semibold mb-4">Order #<?= htmlspecialchars($order_id) ?></h3>
        <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Total Price:</strong> <?= htmlspecialchars($order['total_price_alv']) ?> €</p>
        <p><strong>Delivery Method:</strong> <?= htmlspecialchars($order['delivery_method']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
        <p><strong>City:</strong> <?= htmlspecialchars($order['city']) ?></p>
        <p><strong>State:</strong> <?= htmlspecialchars($order['state']) ?></p>
        <p><strong>Zipcode:</strong> <?= htmlspecialchars($order['zipcode']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($order['country']) ?></p>
    </div>

    <h4 class="text-lg font-semibold mt-6 mb-3">Order Items</h4>
    <?php if (count($order_items) > 0): ?>
        <ul class="space-y-4">
            <?php foreach ($order_items as $item): ?>
                <a href="product.php?id=<?= urlencode($item['product_id']) ?>&from=order_details&order_id=<?= urlencode($order_id) ?>" class="block hover:bg-blue-100 transition duration-200 border-b p-2 rounded">
                    <li class="flex justify-between items-center">
                        <span><?= htmlspecialchars($item['name']) ?> (x<?= htmlspecialchars($item['quantity']) ?>)</span>
                        <span><?= htmlspecialchars($item['price_alv']) ?> €</span>
                    </li>
                </a>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No items found for this order.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
