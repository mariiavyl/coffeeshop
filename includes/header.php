<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Coffee shop</title>
  <script src="https://cdn.tailwindcss.com"></script>

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
            <li><a href="index.php" class="text-white font-semibold hover:text-gray-300">Shop</a></li>
            <li><a href="knowledge.php" class="text-white font-semibold hover:text-gray-300">Knowledge</a></li>
            <li><a href="login.php" class="text-white font-semibold hover:text-gray-300">Account</a></li>
            <li>
                <a href="cart.php" class="text-white font-semibold hover:text-gray-300 relative">
                    Basket
                    <span id="cart-total-count" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute -top-2 -right-2">
                        <?= $cartCount ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<?php if (!isset($disable_breadcrumbs)) include 'breadcrumbs.php'; ?>




