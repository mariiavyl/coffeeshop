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

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">

            <img src="<?=!empty($product['image_url']) ? $product['image_url'] : '2.jpg'; ?>" class="img-fluid">

        </div>
        <div class="col-md-6">

            <h2><?= htmlspecialchars($product['name'] ?? 'No name') ?></h2>
            <p><?= htmlspecialchars($product['description'] ?? 'No description available') ?></p>
            <p class="text-danger"><?= htmlspecialchars($product['price'] ?? '0.00') ?> €</p>
            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                <button type="submit" class="btn btn-success">Add to cart</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
