<?php
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

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Increment the quantity
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            // Add the product to the cart
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
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
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<div class=" flex flex-col h-screen justify-between">
<?php include 'navbar.php'?>
    <main class="container mx-auto p-6 max-w-4xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Your Cart</h2>
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
                            <input type='number' name='quantity' value='{$qty}' min='1' class='form-control w-16 mr-2 text-center'>
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

            // Subtotal inside the table, in a similar style to the total
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
            echo '<a href="process_order.php" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Checkout</a>';
            echo '</div>';
        }
        ?>
    </main>
</body>
<?php include 'includes/footer.php'; ?>
    </div>
