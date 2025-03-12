<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user data
$stmt = $db_connection->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$isEditing = false;
$showSuccessMessage = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $isEditing = true;
    } elseif (isset($_POST['save'])) {
        // Get form data
        $card_number = $_POST['card_number'] ?? $user['card_number'];
        $card_holder = $_POST['card_holder'] ?? $user['card_holder'];
        $expiry_date = $_POST['expiry_date'] ?? $user['expiry_date'];
        $cvv = $_POST['cvv'] ?? $user['cvv'];

        // Check required fields
        if (empty($card_number) || empty($card_holder) || empty($expiry_date) || empty($cvv)) {
            $_SESSION['payment_message'] = [
                'type' => 'warning',
                'text' => 'Card Number, Card Holder, Expiry Date, and CVV are required.'
            ];
        } else {
            try {
                // Update query: ensure all necessary columns exist in the customers table
                $stmt = $db_connection->prepare("UPDATE customers SET card_number = ?, card_holder = ?, expiry_date = ?, cvv = ? WHERE id = ?");
                $stmt->execute([$card_number, $card_holder, $expiry_date, $cvv, $_SESSION['user_id']]);

                // Set success message flag
                $showSuccessMessage = true;

                // Refresh the user data
                $stmt = $db_connection->prepare("SELECT * FROM customers WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Switch back to view mode
                $isEditing = false;
            } catch (PDOException $e) {
                $_SESSION['payment_message'] = [
                    'type' => 'error',
                    'text' => 'Payment data update error: ' . $e->getMessage()
                ];
            }
        }
    }
}
?>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen justify-between">
        <?php include 'navbar.php'; ?>

        <div class="container mx-auto w-full p-6 bg-white mt-8 max-w-4xl rounded-lg flex">
            <!-- Sidebar -->
            <?php include 'includes/sidebar_profile.php'; ?>

            <!-- Payment Methods Content -->
            <div class="flex-1">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Payment Data</h2>

                <!-- Notification -->
                <?php if (isset($_SESSION['payment_message']) || $showSuccessMessage): ?>
                    <div id="notification" class="fixed bottom-4 right-4 p-4
                        <?php
                            if ($showSuccessMessage) {
                                echo 'bg-green-600';
                            } else {
                                echo ($_SESSION['payment_message']['type'] === 'success') ? 'bg-green-600' :
                                     (($_SESSION['payment_message']['type'] === 'warning') ? 'bg-yellow-500' : 'bg-red-600');
                            }
                        ?>
                        text-white rounded-lg shadow-lg">
                        <?php if ($showSuccessMessage): ?>
                            Payment data saved successfully!
                        <?php else: ?>
                            <?= htmlspecialchars($_SESSION['payment_message']['text']) ?>
                        <?php endif; ?>
                    </div>
                    <script>
                        setTimeout(() => {
                            document.getElementById("notification").remove();
                        }, 3000);
                    </script>
                    <?php unset($_SESSION['payment_message']); ?>
                <?php endif; ?>

                <form method="post" id="paymentForm">
                    <!-- Payment Information -->
                    <div class="mb-4">
                        <label for="card_number" class="block text-gray-700">Card Number</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="card_number" id="card_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['card_number']) ?>" required>
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['card_number']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="card_holder" class="block text-gray-700">Card Holder</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="card_holder" id="card_holder" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['card_holder']) ?>" required>
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['card_holder']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4 flex space-x-4">
                        <div class="w-1/2">
                            <label for="expiry_date" class="block text-gray-700">Expiry Date</label>
                            <?php if ($isEditing): ?>
                                <input type="text" name="expiry_date" id="expiry_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['expiry_date']) ?>" required>
                            <?php else: ?>
                                <p><?= htmlspecialchars($user['expiry_date']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="w-1/2">
                            <label for="cvv" class="block text-gray-700">CVV</label>
                            <?php if ($isEditing): ?>
                                <input type="password" name="cvv" id="cvv" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['cvv']) ?>" maxlength="3" required>
                            <?php else: ?>
                                <p>***</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <?php if ($isEditing): ?>
                            <button type="submit" name="save" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">Save Changes</button>
                        <?php else: ?>
                            <button type="submit" name="edit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200">Edit Payment Data</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
        // Automatically format the expiry date as MM/YY
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '').slice(0, 4); // remove non-digits and limit length
            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
