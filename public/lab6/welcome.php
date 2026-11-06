<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=' . urlencode('Спочатку увійдіть у систему'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Особистий кабінет</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; }
        .card { background: #f4f4f4; padding: 20px; border-radius: 8px; border-left: 5px solid #28a745;}
    </style>
</head>
<body>
    <div class="card">
        <h1>Вітаємо, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</h1>
        <p>Ви успішно увійшли в систему.</p>
        <p><small>Ваш ID в базі даних: <?= htmlspecialchars($_SESSION['user_id']) ?></small></p>
    </div>
    
    <p style="margin-top: 20px;">
        <a href="logout.php">Вийти з системи</a>
    </p>
</body>
</html>