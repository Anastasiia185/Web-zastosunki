<?php
session_start();

$currentCart = $_SESSION['cart'] ?? [];

if (!empty($currentCart)) {
    $previous = isset($_COOKIE['previous_purchases'])
        ? json_decode($_COOKIE['previous_purchases'], true)
        : [];

    if (!is_array($previous)) {
        $previous = [];
    }

    $all = array_values(array_unique(array_merge($previous, $currentCart)));

    setcookie(
        'previous_purchases',
        json_encode($all),
        time() + 60 * 60 * 24 * 30,
        '/'
    );
}

$_SESSION['cart'] = [];

header('Location: index.php');
exit;