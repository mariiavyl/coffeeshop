<?php
include 'includes/db.php';
$disable_breadcrumbs = true;
include 'includes/header.php';


// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if order_id is set in the URL
if (!isset($_GET['order_id']) || !isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$order_id = $_GET['order_id'];

// Fetch user data
$stmt = $db_connection->prepare("SELECT email, name, lastname, address, phone FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch ordered items using the order_id
$ordered_items = [];
$total_price_alv = 0;
$stmt = $db_connection->prepare("SELECT order_items.product_id, products.name, order_items.quantity, order_items.price_alv
                                 FROM order_items
                                 JOIN products ON order_items.product_id = products.id
                                 WHERE order_items.order_id = ?");
$stmt->execute([$order_id]);
$ordered_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($ordered_items as &$item) {
    $item['total'] = $item['price_alv'] * $item['quantity'];
    $total_price_alv += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J2CXNQYNMZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-J2CXNQYNMZ');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <main class="container mx-auto p-6 flex flex-col items-center">
        <h2 class="text-2xl font-semibold text-green-600 mb-4 flex items-center gap-2">
            Order Placed Successfully!
            <span class="bg-green-500 text-white rounded-full p-1 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </span>
        </h2>

        <!-- Recipient Details (перемещён вверх) -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 max-w-lg w-full">
            <h3 class="text-xl font-semibold mb-4">Recipient Details</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name'] . ' ' . $user['lastname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
        </div>

        <!-- Order Summary (перемещён вниз) -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 max-w-lg w-full">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
            <table class="min-w-full mb-4">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Product</th>
                        <th class="py-2 px-4 border-b text-left">Quantity</th>
                        <th class="py-2 px-4 border-b text-left">Price</th>
                        <th class="py-2 px-4 border-b text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordered_items as $item): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['quantity']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['price_alv']) ?> €</td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($item['total']) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="flex justify-end">
                <div class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-right shadow-sm">
                    <strong class="text-gray-800">Total Amount: <?= htmlspecialchars($total_price_alv) ?> €</strong>
                </div>
            </div>
        </div>

        <!-- Return Button -->
        <div class="flex justify-end w-full max-w-lg">  
            <a href="index.php" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 inline-block">
                Return to Shopping
            </a>
        </div>
    </main>
</body>
</html>

<?php include 'includes/footer.php'; ?>
