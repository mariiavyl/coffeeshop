<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch orders for the logged-in user
$stmt = $db_connection->prepare("SELECT id, order_date, total_price_alv, delivery_method FROM orders WHERE customer_id = ? ORDER BY order_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen justify-between">
        <?php include 'navbar.php'; ?>

        <div class="container mx-auto w-full p-6 bg-white mt-8 max-w-5xl mb-12 rounded-lg flex">
            <!-- Sidebar -->
            <?php include 'includes/sidebar_profile.php'; ?>

            <!-- Your Orders Content -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Your Orders</h2>
                </div>

                <?php if (count($orders) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                                    <th class="py-3 px-4 text-left first:rounded-tl-lg">Order Date</th>
                                    <th class="py-3 px-4 text-left">Total Price (€)</th>
                                    <th class="py-3 px-4 text-left">Delivery Method</th>
                                    <th class="py-3 px-4 text-center last:rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($orders as $order): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 text-gray-800"><?= htmlspecialchars($order['order_date']) ?></td>
                                        <td class="py-3 px-4 text-gray-800 font-medium"><?= htmlspecialchars($order['total_price_alv']) ?> €</td>
                                        <td class="py-3 px-4 text-gray-800"><?= htmlspecialchars($order['delivery_method']) ?></td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="order_details.php?id=<?= urlencode($order['id']) ?>" class="border border-gray-400 text-gray-800 px-2 py-1 rounded-lg hover:bg-gray-300 transition duration-200">View Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 text-center">You have no previous orders.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>
</body>

</html>
