<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $db_connection->prepare("SELECT order_date, total_price FROM orders WHERE customer_id = ? ORDER BY order_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Your Orders</h2>

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
                            <td class="py-3 px-4 text-gray-800 font-medium"><?= htmlspecialchars($order['total_price']) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center">You have no previous orders.</p>
    <?php endif; ?>

    <div class="mt-6 text-center">
        <a href="profile.php" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Back to Profile
        </a>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
