<?php
session_start();

// Подсчитываем количество товаров в корзине
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

header('Content-Type: application/json');
echo json_encode(['count' => $cartCount]);

