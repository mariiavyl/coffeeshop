<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error_message = '';
$success_message = '';

// Получаем текущий пароль пользователя
$stmt = $db_connection->prepare("SELECT password FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$current_password = $user['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password_input = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($current_password_input) || empty($new_password) || empty($confirm_password)) {
        $error_message = 'All fields are required.';
    } elseif ($current_password_input !== $current_password) {
        $error_message = 'Current password is incorrect.';
    } elseif ($new_password !== $confirm_password) {
        $error_message = 'New passwords do not match!';
    } else {
        try {
            // Обновляем пароль без хеширования
            $stmt = $db_connection->prepare("UPDATE customers SET password = ? WHERE id = ?");
            $stmt->execute([$new_password, $_SESSION['user_id']]);

            $success_message = 'Password updated successfully!';
        } catch (PDOException $e) {
            $error_message = 'Error updating password: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white mt-8 max-w-lg rounded-lg">
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Change Password</h2>
    <a href="profile.php" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Profile
    </a>
</div>


    <?php if ($error_message): ?>
        <div id="warning-notification" class="fixed bottom-4 right-4 p-4 bg-yellow-500 text-white rounded-lg shadow-lg">
            <?= $error_message ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("warning-notification").remove();
            }, 3000);
        </script>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div id="success-notification" class="fixed bottom-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg">
            <?= $success_message ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("success-notification").remove();
            }, 3000);
        </script>
    <?php endif; ?>

    <form method="post">
        <div class="mb-4">
            <label for="current_password" class="block text-gray-700">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label for="new_password" class="block text-gray-700">New Password</label>
            <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">Change Password</button>
    </form>
</div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
