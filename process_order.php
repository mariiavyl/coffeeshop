<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user data including address information
$stmt = $db_connection->prepare("SELECT email, name, lastname, address, city, state, zipcode, country, phone, card_number, card_holder, expiry_date, cvv FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$order_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zipcode = $_POST['zipcode'] ?? '';
    $country = $_POST['country'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $delivery_method = $_POST['delivery_method'] ?? '';

    if (empty($email) || empty($name) || empty($lastname) || empty($address) || empty($city) || empty($state) || empty($zipcode) || empty($country) || empty($phone) || empty($delivery_method)) {
        $error_message = "All fields are required!";
    } else {
        try {
            $db_connection->beginTransaction();

            $total_price_alv = 0;
            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $stmt_product = $db_connection->prepare("SELECT price_alv FROM products WHERE id = ?");
                $stmt_product->execute([$product_id]);
                $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                $total_price_alv += $product['price_alv'] * $qty;
            }

            $stmt = $db_connection->prepare("INSERT INTO orders (customer_id, total_price_alv, delivery_method, address, city, state, zipcode, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $total_price_alv, $delivery_method, $address, $city, $state, $zipcode, $country]);
            $order_id = $db_connection->lastInsertId();

            $stmt = $db_connection->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_alv) VALUES (?, ?, ?, ?)");
            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $stmt_product = $db_connection->prepare("SELECT price_alv FROM products WHERE id = ?");
                $stmt_product->execute([$product_id]);
                $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                $stmt->execute([$order_id, $product_id, $qty, $product['price_alv']]);
            }

            $db_connection->commit();
            $_SESSION['cart'] = [];
            $order_success = true;

            // Redirect to order_success.php with order ID
            header("Location: order_success.php?order_id=$order_id");
            exit;
        } catch (PDOException $e) {
            $db_connection->rollBack();
            $error_message = "Error processing order: " . $e->getMessage();
        }
    }
}
?>

<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white mt-8 max-w-4xl rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Checkout</h2>

    <?php if ($order_success): ?>
        <div class="bg-green-600 text-white p-4 rounded-lg shadow-lg mb-4">
            Order placed successfully!
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-lg mb-4">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form method="post" id="checkoutForm">
        <!-- Personal Information -->
        <div class="p-4 border rounded-lg mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">First Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['lastname']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
        </div>

        <!-- Address Information -->
        <div class="p-4 border rounded-lg mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Address Information</h3>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['address']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="city" class="block text-gray-700">City</label>
                <input type="text" name="city" id="city" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['city']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="state" class="block text-gray-700">State</label>
                <input type="text" name="state" id="state" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['state']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="zipcode" class="block text-gray-700">Zipcode</label>
                <input type="text" name="zipcode" id="zipcode" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['zipcode']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="country" class="block text-gray-700">Country</label>
                <input type="text" name="country" id="country" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['country']) ?>" required>
            </div>
        </div>

        <!-- Delivery Method -->
        <div class="p-4 border rounded-lg mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Delivery Method</h3>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="delivery_method" value="door_delivery" class="form-radio" required>
                    <span class="ml-2">Door Delivery</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="delivery_method" value="post_office" class="form-radio" required>
                    <span class="ml-2">Post Office</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="delivery_method" value="pickup" class="form-radio" required>
                    <span class="ml-2">Pickup</span>
                </label>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="p-4 border rounded-lg mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h3>
            <div class="mb-4">
                <label for="card_number" class="block text-gray-700">Card Number</label>
                <input type="text" name="card_number" id="card_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['card_number']) ?>" required pattern="\d{16}">
            </div>

            <div class="mb-4">
                <label for="card_holder" class="block text-gray-700">Card Holder</label>
                <input type="text" name="card_holder" id="card_holder" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['card_holder']) ?>" required pattern="[A-Za-z ]+">
            </div>

            <div class="mb-4 flex space-x-6">
                <div class="w-1/2">
                    <label for="expiry_date" class="block text-gray-700">Expiry Date</label>
                    <input type="text" name="expiry_date" id="expiry_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['expiry_date']) ?>" required pattern="(0[1-9]|1[0-2])\/\d{2}">
                </div>

                <div class="w-1/2">
                    <label for="cvv" class="block text-gray-700">CVV</label>
                    <input type="password" name="cvv" id="cvv" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['cvv']) ?>" required pattern="\d{3}">
                </div>
            </div>
        </div>

        <button type="submit" name="confirm_order" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Confirm Order</button>
    </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const phoneInput = document.querySelector("#phone");

    if (phoneInput) {
        const iti = window.intlTelInput(phoneInput, {
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(response => response.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            preferredCountries: ['fi', 'us', 'gb'],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        document.getElementById("checkoutForm").addEventListener("submit", function() {
            phoneInput.value = iti.getNumber();
        });
    }

    const expiryDateInput = document.querySelector("#expiry_date");
    const cvvInput = document.querySelector("#cvv");

    expiryDateInput.addEventListener("input", function(event) {
        let value = event.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        event.target.value = value;
    });

    cvvInput.addEventListener("input", function(event) {
        if (event.target.value.length > 3) {
            event.target.value = event.target.value.slice(0, 3);
        }
    });
});
</script>

<style>
    .iti {
        width: 100%;
    }
</style>

</body>
</html>

<?php include 'includes/footer.php'; ?>
