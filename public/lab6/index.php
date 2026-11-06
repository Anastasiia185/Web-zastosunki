<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 40px auto; }
        input { width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box; }
        button { padding: 10px; width: 100%; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px;}
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Реєстрація</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <form action="register.php" method="post">
        <label>Ім'я користувача:</label>
        <input type="text" name="username" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Пароль:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Зареєструватися</button>
    </form>
    
    <p>Вже є акаунт? <a href="login.php">Увійти</a></p>
</body>
</html>