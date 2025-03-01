<?php
include 'includes/db.php';  // Подключение к базе данных
include 'includes/header.php';  // Подключение шапки

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Получаем данные из формы
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';  // Добавлено поле для имени
    $lastname = $_POST['lastname'] ?? '';  // Добавлено поле для фамилии
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
     

    // Проверка на пустые поля
    if (empty($email) || empty($password) || empty($phone) || empty($password_confirm) || empty($name) || empty($lastname) ) {
        echo '<div id="warning-notification" class="fixed bottom-4 right-4 p-4 bg-yellow-500 text-white rounded-lg shadow-lg">
            All fields are required
          </div>
          <script>
            setTimeout(() => {
                document.getElementById("warning-notification").remove();
            }, 3000);
          </script>';
} elseif ($password !== $password_confirm) {
    echo '<div id="warning-notification" class="fixed bottom-4 right-4 p-4 bg-red-600 text-white rounded-lg shadow-lg">
            Password does not match
          </div>
          <script>
            setTimeout(() => {
                document.getElementById("warning-notification").remove();
            }, 3000);
          </script>';
    } else {

        // Проверка на уникальность email
        $stmt = $db_connection->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            echo "<div class='text-red-600 text-center'>Email already taken!</div>";
        } else {

            try {
                 $stmt = $db_connection->prepare("INSERT INTO customers (name, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?) ?");
                 $stmt->execute([$name, $lastname, $email, $phone, $password]);

                // Если данные успешно вставлены, редирект на страницу профиля
                if ($stmt->rowCount() > 0) {
                    header('Location: profile.php');
                    exit;
                } else {
                    echo "<div class='text-red-600 text-center'>Error registering user! Data not inserted.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='text-red-600 text-center'>Database error: " . $e->getMessage() . "</div>";
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
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label for="lastname" class="block text-gray-700">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label for="phone" class="block text-gray-700">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
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

    <!-- <?php include 'includes/footer.php'; ?> -->

     <style>
    .iti {
        width: 100%; /* Внешняя обертка для корректной ширины */
    }
     </style>

    <script>
    const phoneInput = document.getElementById('phone');
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "fi", 
        separateDialCode: true,
        nationalMode: false,  
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/utils.js",
    });
</script>
</body>
</html>