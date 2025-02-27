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
?>

<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <img src="<?= !empty($product['image_url']) ? $product['image_url'] : '2.jpg'; ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-auto rounded-md shadow-md">
        </div>

        <!-- Product Details -->
        <div>
            <h2 class="text-3xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars($product['name'] ?? 'No name') ?></h2>
            <p class="text-gray-600 mb-4"><?= htmlspecialchars($product['description'] ?? 'No description available') ?></p>
             <!-- ALV 25,5 -->
            <p class="text-2xl text-red-600 font-bold mb-6"><?= htmlspecialchars(number_format(($product['price'] ?? 0) * 1.255, 2, '.', ''))?> €</p>  
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

<?php include 'includes/footer.php'; ?>
