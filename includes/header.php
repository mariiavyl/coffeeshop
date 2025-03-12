<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="icon" href="logo.png" sizes="16x16" type="image/png">
    <link rel="icon" href="logo.png" sizes="32x32" type="image/png">
    <link rel="icon" href="logo.png" sizes="48x48" type="image/png">
    <link rel="icon" href="logo.png" sizes="192x192" type="image/png">

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
        /* .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 75.9vh;
        }
   .content-wrapper {
            flex: 1;
            display: flex;
        }
        .footer {
            width: 100%;
        } */

</style>
    
</head>
