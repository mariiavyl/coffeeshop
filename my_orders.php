<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $db_connection->prepare("SELECT order_date, total_price_alv FROM orders WHERE customer_id = ? ORDER BY order_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Your Orders</h2>
    <a href="profile.php" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Profile
    </a>
</div>


    <?php if (count($orders) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 text-left first:rounded-tl-lg">Order Date</th>
                        <th class="py-3 px-4 text-left last:rounded-tr-lg">Total Price (€)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-800"><?= htmlspecialchars($order['order_date']) ?></td>
                            <td class="py-3 px-4 text-gray-800 font-medium"><?= htmlspecialchars($order['total_price_alv']) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center">You have no previous orders.</p>
    <?php endif; ?>
</div>


<?php include 'includes/footer.php'; ?>
