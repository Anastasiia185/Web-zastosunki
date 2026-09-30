<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product = trim($_POST['product'] ?? '');

if ($product !== '') {
    $_SESSION['cart'][] = $product;
}

header('Location: index.php');
exit;