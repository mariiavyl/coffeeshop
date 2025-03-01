<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($email) || empty($password) || empty($password_confirm)) {
        echo "<div class='text-red-600 text-center'>All fields are required!</div>";
    } elseif ($password !== $password_confirm) {
        echo "<div class='text-red-600 text-center'>Passwords do not match!</div>";
    } else {

        $stmt = $db_connection->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "<div class='text-red-600 text-center'>Email already taken!</div>";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db_connection->prepare("INSERT INTO customers (email, password) VALUES (?, ?)");
            if ($stmt->execute([$email, $hashed_password])) {
                echo "<div class='text-green-600 text-center'>Registration successful! You can now log in.</div>";
            } else {
                echo "<div class='text-red-600 text-center'>Error registering user!</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Register</h2>
            <form method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="password_confirm" class="block text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Register</button>
            </form>
            <p class="text-center text-sm mt-4">Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>.</p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
