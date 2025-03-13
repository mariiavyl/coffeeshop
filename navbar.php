<body>
<nav class="bg-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <ul class="flex space-x-4 items-center">
            <li>
                <a href="landing.php" class="text-black font-semibold hover:text-gray-500">
                    <img src="logo_mini.png" alt="Logo" class="h-6 w-auto">
                </a>
            </li>
            <li><a href="index.php" class="text-black font-semibold hover:text-gray-500">Shop</a></li>
            <li><a href="knowledge.php" class="text-black font-semibold hover:text-gray-500">Knowledge</a></li>
            <li><a href="about.php" class="text-black font-semibold hover:text-gray-500">About Us</a></li>
        </ul>
        <div class="relative flex items-center space-x-4">
            <!-- Cart Icon -->
            <a href="cart.php" class="text-black font-semibold hover:text-gray-500 relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
                <span id="cart-total-count" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute -top-2 -right-2">
                    <?= $cartCount ?>
                </span>
            </a>
            <!-- Account Icon -->
            <a href="login.php" class="text-black font-semibold hover:text-gray-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.92 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </a>
        </div>
    </div>
</nav>
<?php if(!isset($disable_breadcrumbs)) {
    ?>
    <div class="w-full p-4">
    <div class="container mx-auto px-4">
    <?php include 'breadcrumbs.php'; ?>
    </div>
</div>
<?php
}
?>


