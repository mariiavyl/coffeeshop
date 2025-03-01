<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Coffee shop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input/build/css/intlTelInput.css">
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/intlTelInput.js"></script>
<script>
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js"),
  });
</script>
</head>
<body>
  <nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
      <ul class="flex space-x-4">
        <li><a href="index.php" class="text-white font-semibold hover:text-gray-300">Coffee</a></li>
        <li><a href="login.php" class="text-white font-semibold hover:text-gray-300">Account</a></li>
        <li><a href="cart.php" class="text-white font-semibold hover:text-gray-300">Basket</a></li>
      </ul>
    </div>
  </nav>


