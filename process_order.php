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
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (empty($email) || empty($name) || empty($lastname) || empty($address) || empty($phone)) {
        $error_message = "All fields are required!";
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
            $error_message = "Error processing order: " . $e->getMessage();
        }
    }
}
?>

<div class="max-w-xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Checkout</h2>

    <?php if ($order_success): ?>
        <p class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">Order placed successfully!</p>
        <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Return to Home</a>
    <?php else: ?>
        <?php if ($error_message): ?>
            <p class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>

            <div>
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
            </div>

            <div>
                <label for="lastname" class="block text-gray-700">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" required>
            </div>

            <div>
                <label for="address" class="block text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
            </div>

            <div>
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
            </div>

            <button type="submit" name="confirm_order" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Confirm Order</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
