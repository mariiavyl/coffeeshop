<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="w-1/4 p-6 mr-20">
    <ul class="space-y-4">
        <li>
            <a href="profile.php" class="<?= $current_page == 'profile.php' ? 'text-blue-600 font-bold' : 'text-gray-700 font-medium' ?> hover:text-blue-700">
                Your Profile
            </a>
        </li>
        <li>
            <a href="my_orders.php" class="<?= $current_page == 'my_orders.php' ? 'text-blue-600 font-bold' : 'text-gray-700 font-medium' ?> hover:text-blue-700">
                Your Orders
            </a>
        </li>
        <li>
            <a href="payment_info.php" class="<?= $current_page == 'payment_info.php' ? 'text-blue-600 font-bold' : 'text-gray-700 font-medium' ?> hover:text-blue-700">
                Payment Methods
            </a>
        </li>
        <li>
            <a href="change_password.php" class="<?= $current_page == 'change_password.php' ? 'text-blue-600 font-bold' : 'text-gray-700 font-medium' ?> hover:text-blue-700">
                Password
            </a>
        </li>
    </ul>
</div>
