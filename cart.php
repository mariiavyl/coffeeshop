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

<div class="container mt-4">
    <h2>Basket</h2>
    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty</p>";
    } else {
        echo '<table class="table">';
        echo '<tr><th>Item</th><th>Quantity</th><th>Price</th><th>Subtotal</th><th>Actions</th></tr>';
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $qty) {
            $stmt = $db_connection->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $sum = $product['price'] * $qty;
            $total += $sum;
            echo "<tr>
                    <td>{$product['name']}</td>
                    <td>
                        <form method='post' style='display:inline-block;'>
                            <input type='number' name='quantity' value='{$qty}' min='1' class='form-control' style='width: 60px;' required>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <button type='submit' name='update' class='btn btn-warning btn-sm'>Update</button>
                        </form>
                    </td>
                    <td>{$product['price']} €</td>
                    <td>{$sum} €</td>
                    <td>
                        <form method='post' style='display:inline-block;'>
                            <input type='hidden' name='product_id' value='{$id}'>
                            <button type='submit' name='remove' class='btn btn-danger btn-sm'>Remove</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "<tr><td colspan='3'><strong>Subtotal:</strong></td><td><strong>{$total} €</strong></td></tr>";
        echo '</table>';
        echo '<a href="process_order.php" class="btn btn-primary">Checkout</a>';
        echo '<a href="index.php" class="btn btn-secondary">Back to Shopping</a>';
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>
