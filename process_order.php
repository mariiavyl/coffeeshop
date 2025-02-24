<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $db_connection->prepare("SELECT email, name, lastname, address, phone FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$order_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (empty($email) || empty($name) || empty($lastname) || empty($address) || empty($phone)) {
        echo "<p class='text-danger'>All fields are required!</p>";
    } else {
        try {
            $db_connection->beginTransaction();

            $total_price = 0;
            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $stmt_product = $db_connection->prepare("SELECT price FROM products WHERE id = ?");
                $stmt_product->execute([$product_id]);
                $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                $total_price += $product['price'] * $qty;
            }

            $stmt = $db_connection->prepare("INSERT INTO orders (customer_id, total_price) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $total_price]);
            $order_id = $db_connection->lastInsertId();
            $stmt = $db_connection->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $stmt_product = $db_connection->prepare("SELECT price FROM products WHERE id = ?");
                $stmt_product->execute([$product_id]);
                $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                $stmt->execute([$order_id, $product_id, $qty, $product['price']]);
            }

            $db_connection->commit();
            $_SESSION['cart'] = []; 
            $order_success = true;
        } catch (PDOException $e) {
            $db_connection->rollBack();
            echo "<p class='text-danger'>Error processing order: " . $e->getMessage() . "</p>";
        }
    }
}

?>

<div class="container mt-4">
    <h2>Checkout</h2>

    <?php if ($order_success): ?>
        <p class="text-success">Order placed successfully!</p>
        <a href="index.php" class="btn btn-primary">Return to Home</a>
    <?php else: ?>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
            </div>
            <button type="submit" name="confirm_order" class="btn btn-success">Confirm Order</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
