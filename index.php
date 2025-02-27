<?php
include 'includes/db.php';
include 'includes/header.php';

$category = $_GET['category'] ?? 'all';
$brand = $_GET['brand'] ?? 'all';

// Get unique brand list from the database
$brandQuery = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != ''";
$brandStmt = $db_connection->query($brandQuery);
$brands = $brandStmt->fetchAll(PDO::FETCH_COLUMN);

$query = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($category !== 'all') {
    $query .= " AND category = ?";
    $params[] = $category;
}

if ($brand !== 'all') {
    $query .= " AND brand = ?";
    $params[] = $brand;
}

$stmt = $db_connection->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto mt-8">
    <h2 class="text-center text-3xl font-semibold mb-8 text-gray-800">Our Coffee & Coffee Makers</h2>

    <div class="text-center mb-6">
        <a href="?category=all&brand=<?= urlencode($brand) ?>" class="bg-gray-500 text-white px-6 py-3 rounded-lg mx-2 hover:bg-gray-600 transition-all duration-200">All</a>
        <a href="?category=coffee&brand=<?= urlencode($brand) ?>" class="bg-blue-500 text-white px-6 py-3 rounded-lg mx-2 hover:bg-blue-600 transition-all duration-200">Coffee</a>
        <a href="?category=coffee_maker&brand=<?= urlencode($brand) ?>" class="bg-blue-500 text-white px-6 py-3 rounded-lg mx-2 hover:bg-blue-600 transition-all duration-200">Coffee Makers</a>
    </div>

    <div class="text-center mb-6">
        <form method="GET" class="inline-block">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <select name="brand" class="form-select px-6 py-3 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="all">All Brands</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= htmlspecialchars($b) ?>" <?= $brand === $b ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($products as $product): ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden flex flex-col h-auto">
                <?php
                $imageUrl = !empty($product['image_url']) ? $product['image_url'] : '2.jpg';
                ?>
                <img src="<?= htmlspecialchars($imageUrl) ?>" class="w-full h-54 object-cover mx-auto" alt="<?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?>"> <!-- Высота 54, сохранение соотношения сторон -->
                <div class="flex flex-col justify-between p-4 h-full">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($product['name'] ?? 'No name') ?></h5>
                        <!-- ALV 25,5 -->
                        <p class="text-lg text-red-500 font-bold mt-1"><?= htmlspecialchars($product['price_alv'] ?? '0.00') ?> €</p>
                    </div>
                    <div class="flex items-center justify-center space-x-2 mt-4 mb-4"> <!-- Добавлен отступ снизу -->
                        <a href="product.php?id=<?= $product['id'] ?>" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all duration-200">View Product</a>
                        <form action="cart.php" method="post" class="flex">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg ml-2 hover:bg-green-600 transition-all duration-200">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
            