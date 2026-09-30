<?php
$savedName = $_COOKIE['username'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
    $name = trim($_POST['username']);

    setcookie('username', $name, time() + 60 * 60 * 24 * 7, '/');

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$savedName = $_COOKIE['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Cookie</title>
</head>
<body>
    <?php if ($savedName): ?>
        <p>Привіт, <strong><?= htmlspecialchars($savedName) ?></strong>! Раді бачити вас знову 👋</p>
        <p><em>(Ім'я збережено в cookie на 7 днів. Спробуйте закрити вкладку і повернутися пізніше.)</em></p>
        <a href="delete.php">🗑 Видалити cookie</a>
    <?php else: ?>
        <p>Введіть своє ім'я:</p>
        <form method="post">
            <input type="text" name="username" required placeholder="Ваше ім'я">
            <button type="submit">Зберегти</button>
        </form>
    <?php endif; ?>
</body>
</html>