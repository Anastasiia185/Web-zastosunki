<?php
session_start();

$login    = trim($_POST['login']    ?? '');
$password = trim($_POST['password'] ?? '');

$validLogin    = 'admin';
$validPassword = '12345';

if ($login === $validLogin && $password === $validPassword) {
    $_SESSION['user'] = [
        'login'      => $login,
        'login_time' => date('Y-m-d H:i:s'),
    ];
    header('Location: session.php');
} else {
    $_SESSION['error'] = 'Невірний логін або пароль.';
    header('Location: session.php');
}
exit;