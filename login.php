<?php
include 'includes/db.php';
include 'includes/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем, существует ли пользователь с таким email
    $stmt = $db_connection->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем, если пользователь найден и пароли совпадают
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
<body class="bg-gray-100">

    <div class="cont justify-center items-center p-40">
        <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
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
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
            </form>
            <p class="text-center text-sm mt-4">Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register here</a>.</p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <style>
  .cont {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 76svh;
  }
  </style>

</body>
</html>