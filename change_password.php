<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error_message = '';
$success_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем текущий пароль пользователя
    $stmt = $db_connection->prepare("SELECT password FROM customers WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_password = $user['password'];

    $current_password_input = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($current_password_input) || empty($new_password) || empty($confirm_password)) {
        // Store error message in session
        $_SESSION['password_change_error'] = 'All fields are required.';
    } elseif ($current_password_input !== $current_password) {
        // Store error message in session
        $_SESSION['password_change_error'] = 'Current password is incorrect.';
    } elseif ($new_password === $current_password) {
        // Store error message in session
        $_SESSION['password_change_error'] = 'New password matches the current password. Please choose a different one.';
    } elseif ($new_password !== $confirm_password) {
        // Store error message in session
        $_SESSION['password_change_error'] = 'New passwords do not match!';
    } else {
        try {
            $stmt = $db_connection->prepare("UPDATE customers SET password = ? WHERE id = ?");
            $stmt->execute([$new_password, $_SESSION['user_id']]);

            // Store success message in session
            $_SESSION['password_change_success'] = 'Password updated successfully!';
        } catch (PDOException $e) {
            // Store error message in session
            $_SESSION['password_change_error'] = 'Error updating password: ' . $e->getMessage();
        }
    }

    // Redirect to the same page to prevent form resubmission
    header('Location: change_password.php');
    exit;
}

// Check for success message in session
if (isset($_SESSION['password_change_success'])) {
    $success_message = $_SESSION['password_change_success'];
    unset($_SESSION['password_change_success']); // Remove the message after displaying
}

// Check for error message in session
if (isset($_SESSION['password_change_error'])) {
    $error_message = $_SESSION['password_change_error'];
    unset($_SESSION['password_change_error']); // Remove the message after displaying
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
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white mt-8 max-w-4xl rounded-lg flex">

    <!-- Sidebar -->
    <?php include 'includes/sidebar_profile.php'?>

    <!-- Change Password Content -->
    <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Change Password</h2>

        <!-- Notification -->
        <?php if ($error_message): ?>
            <div id="warning-notification" class="fixed bottom-4 right-4 p-4 bg-yellow-500 text-white rounded-lg shadow-lg">
                <?= $error_message ?>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById("warning-notification").remove();
                }, 3000);
            </script>
        <?php elseif ($success_message): ?>
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

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">Change Password</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
