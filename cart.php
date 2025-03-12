
<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    // Проверка наличия товара на складе
    $stmt = $db_connection->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product && $quantity > $product['stock']) {
        $error_message = "Only " . $product['stock'] . " items in stock!";
    } else {
        if (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$product_id]);
        } elseif (isset($_POST['update'])) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) 
                ? $_SESSION['cart'][$product_id] + $quantity 
                : $quantity;
        }
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

<body class="bg-gray-100">
<div class=" flex flex-col h-screen justify-between">
<?php include 'navbar.php'?>
    <main class="container mx-auto p-6 max-w-4xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Your Cart</h2>
        
        <?php if (!empty($error_message)): ?>
            <div id="stock-error" class="bg-red-500 text-white p-4 rounded-lg mb-4 text-center">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<p class='text-center text-gray-600'>Your cart is empty</p>";
        } else {
            echo '<table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">';
            echo '<thead class="bg-gray-50">';
            echo '<tr>';
            echo '<th class="py-3 px-4 text-left">Product</th>';
            echo '<th class="py-3 px-4 text-center">Quantity</th>';
            echo '<th class="py-3 px-4 text-center">Price</th>';
            echo '<th class="py-3 px-4 text-center">Total</th>';
            echo '<th class="py-3 px-4 text-center">Actions</th>';
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

                echo "<tr class='border-b'>";
                echo "<td class='py-3 px-4'>{$product['name']}</td>";
                echo "<td class='py-3 px-4'>
                        <form action='cart.php' method='post' class='flex'>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <input type='number' name='quantity' value='{$qty}' min='1' class='form-control w-16 mr-2 text-center' oninput='hideStockError()'>
                            <button type='submit' name='update' class='bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600'>Update</button>
                        </form>
                      </td>";
                echo "<td class='py-3 px-4 text-center'>{$product['price_alv']} €</td>";
                echo "<td class='py-3 px-4 text-center'>{$sum} €</td>";
                echo "<td class='py-3 px-4 text-center'>
                        <form method='post'>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <button type='submit' name='remove' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Remove</button>
                        </form>
                      </td>";
                echo "</tr>";
            }

            echo '<tr class="border-t">';
            echo '<td colspan="3" class="py-3 px-4 text-right font-semibold">Subtotal</td>';
            echo '<td colspan="2" class="py-3 px-4 text-right bg-gray-100 border border-gray-300 rounded-lg shadow-sm text-gray-800">';
            echo "{$total_price_alv} €";
            echo '</td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';

            echo '<div class="flex justify-between mt-6">';
            echo '<a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">Back to Shopping</a>';
            echo '<button onclick="checkStockBeforeCheckout()" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Checkout</button>';
            echo '</div>';
        }
        ?>
    </main>
</body>

<script>
function hideStockError() {
    const errorDiv = document.getElementById('stock-error');
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
}

function checkStockBeforeCheckout() {
    const errorDiv = document.getElementById('stock-error');
    if (errorDiv && errorDiv.style.display !== 'none') {
        alert("Fix the stock issues before proceeding to checkout.");
    } else {
        window.location.href = "process_order.php";
    }
}
</script>

<?php include 'includes/footer.php'; ?>
</div>