
<?php
include 'includes/db.php';
$disable_breadcrumbs = true;
include 'includes/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if a user with the given email exists
    $stmt = $db_connection->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user is found and the passwords match
    if ($user && $user['password'] === $password) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header('Location: profile.php');
        exit;
    } else {
        $error = "Invalid login or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'navbar.php'; ?>
    <div class="flex-grow flex items-center justify-center py-12">
        <div class="content w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login</h2>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="text" name="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <?php if (isset($error)) { echo "<div class='text-red-600 text-center'>$error</div>"; } ?>
                <button type="submit" class="w-full bg-yellow-950 text-white py-2 rounded-md hover:bg-gray-800">Login</button>
            </form>
            <p class="text-center text-sm mt-4">Don't have an account? <a href="register.php" class="text-yellow-950 hover:underline">Register here</a>.</p>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>