<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        header('Location: index.php?error=' . urlencode('Заповніть усі поля'));
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            header('Location: index.php?error=' . urlencode('Користувач з таким ім\'ям або email вже існує'));
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        header('Location: index.php?success=' . urlencode('Реєстрація успішна! Тепер можете увійти.'));
        exit;
        
    } catch (PDOException $e) {
        header('Location: index.php?error=' . urlencode('Помилка бази даних: ' . $e->getMessage()));
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}