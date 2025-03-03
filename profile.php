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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $isEditing = true;
    } elseif (isset($_POST['save'])) {
        // Get form data
        $email    = $_POST['email']    ?? $user['email'];
        $name     = $_POST['name']     ?? $user['name'];
        $lastname = $_POST['lastname'] ?? $user['lastname'];
        $phone    = $_POST['phone']    ?? $user['phone']; // номер телефона
        $address  = $_POST['address']  ?? $user['address'];
        $city     = $_POST['city']     ?? $user['city'];
        $state    = $_POST['state']    ?? $user['state'];
        $zipcode  = $_POST['zipcode']  ?? $user['zipcode'];
        $country  = $_POST['country']  ?? $user['country'];

        // Проверка обязательных полей
        if (empty($email) || empty($name) || empty($lastname) || empty($phone)) {
            $_SESSION['profile_message'] = [
                'type' => 'warning',
                'text' => 'Email, First Name, Last Name, and Phone are required.'
            ];
        } else {
            try {
                // Обновлённый запрос: убедитесь, что в таблице customers существуют все нужные столбцы
                $stmt = $db_connection->prepare("UPDATE customers SET email = ?, name = ?, lastname = ?, phone = ?, address = ?, city = ?, state = ?, zipcode = ?, country = ? WHERE id = ?");
                $stmt->execute([$email, $name, $lastname, $phone, $address, $city, $state, $zipcode, $country, $_SESSION['user_id']]);

                $_SESSION['profile_message'] = [
                    'type' => 'success',
                    'text' => 'Profile updated successfully!'
                ];
            } catch (PDOException $e) {
                $_SESSION['profile_message'] = [
                    'type' => 'error',
                    'text' => 'Profile update error: ' . $e->getMessage()
                ];
            }
        }
        // Редирект для предотвращения повторной отправки формы
        header('Location: profile.php');
        exit;
    }
}
?>

<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white mt-8 max-w-4xl rounded-lg flex">
    <!-- Sidebar -->
    <div class="w-1/4 p-6 mr-20">
        <ul class="space-y-4">
            <li><a href="profile.php" class="text-gray-700 hover:text-gray-900">Your Profile</a></li>
            <li><a href="my_orders.php" class="text-gray-700 hover:text-gray-900">Your Orders</a></li>
            <li><a href="payment_methods.php" class="text-gray-700 hover:text-gray-900">Payment Methods</a></li>
            <li><a href="account_security.php" class="text-gray-700 hover:text-gray-900">Account Security</a></li>
            <li><a href="permissions.php" class="text-gray-700 hover:text-gray-900">Access Rights</a></li>
        </ul>
    </div>

    <!-- Profile Content -->
    <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your Profile</h2>

        <!-- Notification -->
        <?php if (isset($_SESSION['profile_message'])): ?>
            <div id="notification" class="fixed bottom-4 right-4 p-4 
                <?php 
                    echo ($_SESSION['profile_message']['type'] === 'success') ? 'bg-green-600' : 
                         (($_SESSION['profile_message']['type'] === 'warning') ? 'bg-yellow-500' : 'bg-red-600'); 
                ?> 
                text-white rounded-lg shadow-lg">
                <?= htmlspecialchars($_SESSION['profile_message']['text']) ?>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById("notification").remove();
                }, 3000);
            </script>
            <?php unset($_SESSION['profile_message']); ?>
        <?php endif; ?>

        <form method="post" id="profileForm">
            <!-- Общая информация -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <?php if ($isEditing): ?>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['email']) ?>" required>
                <?php else: ?>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">First Name</label>
                <?php if ($isEditing): ?>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['name']) ?>" required>
                <?php else: ?>
                    <p><?= htmlspecialchars($user['name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Last Name</label>
                <?php if ($isEditing): ?>
                    <input type="text" name="lastname" id="lastname" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['lastname']) ?>" required>
                <?php else: ?>
                    <p><?= htmlspecialchars($user['lastname']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Номер телефона перемещён выше блока адресов -->
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <?php if ($isEditing): ?>
                    <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['phone']) ?>" required>
                <?php else: ?>
                    <p><?= htmlspecialchars($user['phone']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Блок адресной информации -->
            <div class="p-4 border rounded-lg mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Address Information</h3>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700">Address</label>
                    <?php if ($isEditing): ?>
                        <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['address']) ?>">
                    <?php else: ?>
                        <p><?= htmlspecialchars($user['address']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-wrap -mx-2">
                    <!-- Ряд 1: City и State/Region -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        <label for="city" class="block text-gray-700">City</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="city" id="city" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['city'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        <label for="state" class="block text-gray-700">State/Region</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="state" id="state" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['state'] ?? '') ?>">
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['state'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>
                    <!-- Ряд 2: Zip/Postal Code и Country -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        <label for="zipcode" class="block text-gray-700">Zip/Postal Code</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="zipcode" id="zipcode" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['zipcode'] ?? '') ?>">
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['zipcode'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        <label for="country" class="block text-gray-700">Country</label>
                        <?php if ($isEditing): ?>
                            <input type="text" name="country" id="country" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?= htmlspecialchars($user['country'] ?? '') ?>">
                        <?php else: ?>
                            <p><?= htmlspecialchars($user['country'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="flex justify-start space-x-4 mt-8">
                <?php if ($isEditing): ?>
                    <button type="submit" name="save" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">Save Changes</button>
                <?php else: ?>
                    <button type="submit" name="edit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200">Edit Profile</button>
                <?php endif; ?>

                <?php if (!$isEditing): ?>
                    <a href="change_password.php" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200">Change Password</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
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

        document.getElementById("profileForm").addEventListener("submit", function() {
            phoneInput.value = iti.getNumber();
        });
    }
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
