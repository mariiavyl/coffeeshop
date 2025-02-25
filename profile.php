<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($email) || empty($name) || empty($lastname) || empty($address) || empty($phone)) {
        echo "<p class='text-red-500'>All fields are required!</p>";
    } elseif ($password !== $password_confirm) {
        echo "<p class='text-red-500'>Passwords do not match!</p>";
    } else {
        try {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db_connection->prepare("UPDATE customers SET email = ?, name = ?, lastname = ?, address = ?, phone = ?, password = ? WHERE id = ?");
                $stmt->execute([$email, $name, $lastname, $address, $phone, $hashed_password, $_SESSION['user_id']]);
            } else {
                $stmt = $db_connection->prepare("UPDATE customers SET email = ?, name = ?, lastname = ?, address = ?, phone = ? WHERE id = ?");
                $stmt->execute([$email, $name, $lastname, $address, $phone, $_SESSION['user_id']]);
            }

            echo "<p class='text-green-500'>Profile updated successfully!</p>";
        } catch (PDOException $e) {
            echo "<p class='text-red-500'>Error updating profile: " . $e->getMessage() . "</p>";
        }
    }
}

$stmt = $db_connection->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6 bg-white mt-8 max-w-lg rounded-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Your Profile</h2>
        <a href="my_orders.php" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 text-sm">
            View My Orders
        </a>
    </div>

    <form method="post">
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="lastname" class="block text-gray-700">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address</label>
            <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Phone</label>
            <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label for="password_confirm" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition duration-200">Save Changes</button>
            <a href="logout.php" class="bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition duration-200">Logout</a>
        </div>
    </form>

</div>

<script>
    const phoneInput = document.querySelector("#phone");
    const iti = window.intlTelInput(phoneInput, {
        separateDialCode: true,
        initialCountry: "FI", 
        geoIpLookup: function(callback) {
            fetch("https://ipinfo.io?token=your_ipinfo_token", { method: "GET" })
                .then(response => response.json())
                .then(data => callback(data.country));
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    document.querySelector("form").addEventListener("submit", function() {
        document.querySelector("#phone").value = iti.getNumber();
    });
</script>

</body>
</html>

<?php include 'includes/footer.php'; ?>