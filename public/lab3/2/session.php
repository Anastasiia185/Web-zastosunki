<?php
session_start();  

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head><meta charset="UTF-8"><title>Сесія</title></head>
    <body>
        <h1>Ви вже увійшли </h1>
        <p>Вітаємо, <strong><?= htmlspecialchars($user['login']) ?></strong>!</p>
        <p>Час входу: <?= htmlspecialchars($user['login_time']) ?></p>
        <a href="logout.php"> Вийти</a>
    </body>
    </html>
    <?php
    exit;
}

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>Вхід</title></head>
<body>
    <h1>Вхід у систему</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label>Логін: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <button type="submit">Увійти</button>
    </form>

    <p><em>Підказка: правильні логін/пароль — <code>admin</code> / <code>12345</code></em></p>
</body>
</html>