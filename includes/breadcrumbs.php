<?php
// header.php
include 'includes/db.php';  // Пример подключения к БД, если необходимо
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="path/to/tailwind.css"> <!-- Подключаем Tailwind CSS -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">

    <?php
function generate_breadcrumbs() {
    // URL segments to exclude from breadcrumbs
    $excludeSegments = ['coffeeshop'];

    // Get the current URL
    $url = $_SERVER['REQUEST_URI'];

    // Split the URL into parts
    $parts = explode('/', trim($url, '/'));

    // Check if we are on the homepage
    if (end($parts) === 'index.php' || empty($parts[0])) {
        // If on the homepage, return only "Home"
        return '<a href="index.php">Home</a>';
    }

    // Start with the home link
    $breadcrumbs = '<a href="index.php">Home</a>';

    // Generate breadcrumbs for other pages
    $path = '';
    foreach ($parts as $index => $part) {
        $path .= '/' . $part;
        // Remove .php extension for display
        $displayName = str_replace('.php', '', ucfirst(str_replace('-', ' ', $part)));

        if (!in_array($part, $excludeSegments)) {
            if ($index < count($parts) - 1) {
                // If it's not the last element, add a link
                $breadcrumbs .= ' > <a href="' . $path . '">' . $displayName . '</a>';
            } else {
                // If it's the last element, just display the text
                $breadcrumbs .= ' > ' . $displayName;
            }
        }
    }

    return $breadcrumbs;
}
?>
        <div class="text-gray-700">
            <?php echo generate_breadcrumbs(); ?>
        </div>
    </div>
