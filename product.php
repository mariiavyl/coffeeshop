<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: Missing or invalid product ID!");
}

$id = intval($_GET['id']);
$stmt = $db_connection->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Error: Product not found!");
}

$fromOrderDetails = isset($_GET['from']) && $_GET['from'] === 'order_details';
$order_id = $fromOrderDetails ? intval($_GET['order_id']) : null;
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
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 mt-8 max-w-4xl">

    <?php $fromStore = isset($_GET['from']) && $_GET['from'] === 'store'; ?>

<?php if ($fromOrderDetails && $order_id): ?>
    <a href="order_details.php?id=<?= urlencode($order_id) ?>" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Return to Order
    </a>
<?php elseif ($fromStore): ?>
    <a href="index.php" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Store
    </a>
<?php endif; ?>


        <div class="bg-white rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div>
                    <img src="<?= !empty($product['image_url']) ? $product['image_url'] : '2.jpg'; ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-auto rounded-md shadow-md">
                </div>

                <!-- Product Details -->
                <div>
                    <h2 class="text-3xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars($product['name'] ?? 'No name') ?></h2>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($product['description'] ?? 'No description available') ?></p>
                    <p class="text-2xl text-red-600 font-bold mb-6"><?= htmlspecialchars($product['price_alv'] ?? '0.00') ?> €</p>

                    <form action="cart.php" method="post" class="space-y-4">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                        <div>
                            <label for="quantity" class="block text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
