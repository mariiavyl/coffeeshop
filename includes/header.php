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
</head>
<body>
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <ul class="flex space-x-4 items-center">
            <li>
                <a href="index.php" class="text-white font-semibold hover:text-gray-300">
                    <img src="logo mini.png" alt="Logo" class="h-6 w-auto">
                </a>
            </li>
             <li><a href="index.php" class="text-white font-semibold hover:text-gray-300">Shop</a></li>
            <li><a href="knowledge.php" class="text-white font-semibold hover:text-gray-300">Knowledge</a></li>
           
        </ul>
        <div class="relative flex items-center space-x-4">
            <!-- Language Dropdown -->
            <div class="relative">
                <button id="language-dropdown" class="text-white font-semibold hover:text-gray-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
                    </svg>
                    <span class="ml-2">EN</span>
                </button>
                <div id="language-dropdown-menu" class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">English</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Finnish</a>
                </div>
            </div>
            <!-- Cart Icon -->
            <a href="cart.php" class="text-white font-semibold hover:text-gray-300 relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
                <span id="cart-total-count" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute -top-2 -right-2">
                    <?= $cartCount ?>
                </span>
            </a>
            <!-- Account Icon -->
            <a href="login.php" class="text-white font-semibold hover:text-gray-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.92 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </a>
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const languageDropdown = document.getElementById("language-dropdown");
    const languageDropdownMenu = document.getElementById("language-dropdown-menu");

    languageDropdown.addEventListener("click", function() {
        languageDropdownMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", function(event) {
        if (!languageDropdown.contains(event.target) && !languageDropdownMenu.contains(event.target)) {
            languageDropdownMenu.classList.add("hidden");
        }
    });
});
</script>

<?php if (!isset($disable_breadcrumbs)) include 'breadcrumbs.php'; ?>
