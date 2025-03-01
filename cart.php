<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove'])) {
        $product_id = $_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);
    } elseif (isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $_SESSION['cart'][$product_id] = $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    </nav>

    <main class="container mx-auto p-6">
        <h2 class="text-xl font-semibold mb-4">Your Cart</h2>
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<p class='text-center'>Your cart is empty</p>";
        } else {
            echo '<table class="min-w-full bg-white rounded-lg shadow-md p-6">';  // Паддинг для таблицы
            echo '<thead>';
            echo '<tr>';
            echo '<th class="py-2 px-4 border-b text-center">Product</th>';  // Меньший паддинг для ячеек
            echo '<th class="py-2 px-4 border-b text-center">Quantity</th>';  // Меньший паддинг для ячеек
            echo '<th class="py-2 px-4 border-b text-center">Price</th>';  // Меньший паддинг для ячеек
            echo '<th class="py-2 px-4 border-b text-center">Total</th>';  // Меньший паддинг для ячеек
            echo '<th class="py-2 px-4 border-b text-center">Actions</th>';  // Меньший паддинг для ячеек
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $total_price_alv = 0;
            foreach ($_SESSION['cart'] as $id => $qty) {
                $stmt = $db_connection->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                $sum = $product['price_alv'] * $qty;
                $total_price_alv += $sum;

                echo "<tr>";
                echo "<td class='py-2 px-4 border-b text-center'>{$product['name']}</td>";  // Меньший паддинг для ячеек
                echo "<td class='py-2 px-4 border-b text-center'>
                        <form method='post' style='display:inline-block;'>
                            <input type='number' name='quantity' value='{$qty}' min='1' class='form-control' style='width: 60px;' required>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <button type='submit' name='update' class='bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600'>Update</button>
                        </form>
                      </td>";  // Меньший паддинг для ячеек
                echo "<td class='py-2 px-4 border-b text-center'>{$product['price_alv']} €</td>";  // Меньший паддинг для ячеек
                echo "<td class='py-2 px-4 border-b text-center'>{$sum} €</td>";  // Меньший паддинг для ячеек
                echo "<td class='py-2 px-4 border-b text-center'>
                        <form method='post' style='display:inline-block;'>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <button type='submit' name='remove' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Remove</button>
                        </form>
                      </td>";  // Меньший паддинг для ячеек
                echo "</tr>";
            }

            echo "<tr><td colspan='3' class='text-right py-2 px-4'><strong>Subtotal:</strong></td><td class='text-center py-2 px-4'><strong>{$total_price_alv} €</strong></td></tr>";  // Меньший паддинг для ячеек
            echo '</tbody>';
            echo '</table>';

            echo '<div class="flex justify-between mt-6">';
            echo '<a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">Back to Shopping</a>';
            echo '<a href="process_order.php" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Checkout</a>';
            echo '</div>';
        }
        ?>
    </main>
</body>
</html>

<?php include 'includes/footer.php'; ?>
