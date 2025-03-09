<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $agree = isset($_POST['agree']);

    if (empty($email) || empty($password) || empty($phone) || empty($password_confirm) || empty($name) || empty($lastname)) {
        echo '<div class="text-red-600 text-center">All fields are required</div>';
    } elseif ($password !== $password_confirm) {
        echo '<div class="text-red-600 text-center">Password does not match</div>';
    } elseif (!$agree) {
        echo '<div class="text-red-600 text-center">You must agree to the data processing</div>';
    } else {
        $stmt = $db_connection->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "<div class='text-red-600 text-center'>Email already taken!</div>";
        } else {
            try {
                // Вставляем пароль без хеширования
                $stmt = $db_connection->prepare("INSERT INTO customers (name, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $lastname, $email, $phone, $password]);

                if ($stmt->rowCount() > 0) {
                    // Получаем ID нового пользователя
                    $user_id = $db_connection->lastInsertId();

                    // Сохраняем данные в сессии
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;

                    // Редирект в личный кабинет
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
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex justify-center py-12">
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
                
                <div class="flex items-center">
                    <input type="checkbox" name="agree" class="mr-2" required>
                    <label for="agree" class="text-gray-700">I agree to the processing of my data</label>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Register</button>
            </form>
            <p class="text-center text-sm mt-4">Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>.</p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <style>
        .iti {
            width: 100%; /* Внешняя обертка для корректной ширины */
        }
    </style>

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

            document.querySelector("form").addEventListener("submit", function() {
                phoneInput.value = iti.getNumber();
            });
        }
    });
    </script>
</body>
</html>