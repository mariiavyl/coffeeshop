<?php
include 'includes/db.php';
include 'includes/header.php';

$category = $_GET['category'] ?? 'all';
$brand = $_GET['brand'] ?? 'all';

// Получаем список уникальных брендов из базы
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

<div class="container mt-4">
    <h2 class="text-center mb-4">Our Coffee & Coffee Makers</h2>

    <div class="text-center mb-3">
        <a href="?category=all&brand=<?= urlencode($brand) ?>" class="btn btn-secondary">All</a>
        <a href="?category=coffee&brand=<?= urlencode($brand) ?>" class="btn btn-primary">Coffee</a>
        <a href="?category=coffee_maker&brand=<?= urlencode($brand) ?>" class="btn btn-primary">Coffee Makers</a>
    </div>

    <div class="text-center mb-3">
        <form method="GET">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <select name="brand" class="form-select d-inline w-auto" onchange="this.form.submit()">
                <option value="all">All Brands</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= htmlspecialchars($b) ?>" <?= $brand === $b ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php
                    $imageUrl = !empty($product['image_url']) ? $product['image_url'] : '2.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($imageUrl) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name'] ?? 'No name') ?></h5>
                        <p class="text-danger"><strong><?= htmlspecialchars($product['price'] ?? '0.00') ?> €</strong></p>
                        <div class="btn-group">
                        <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary">View Product</a>
                        <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="quantity" value="1" class="form-control mb-2">
                        <button type="submit" class="btn btn-success">Add to cart</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
