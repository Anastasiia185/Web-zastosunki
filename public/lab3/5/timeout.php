<?php
session_start();

const INACTIVITY_LIMIT = 5 * 60;

$message = '';

if (isset($_SESSION['user'])) {

    $now = time();
    $last = $_SESSION['last_activity'] ?? $now;
    $idle = $now - $last;

    if ($idle > INACTIVITY_LIMIT) {
        $_SESSION = [];
        session_destroy();
        session_start();  
        $message = '⏰ Сесію завершено через неактивність (більше 5 хвилин).';
    } else {
        $_SESSION['last_activity'] = $now;
        $remaining = INACTIVITY_LIMIT - $idle;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login = trim($_POST['login']);

    if ($login !== '') {
        $_SESSION['user'] = $login;
        $_SESSION['last_activity'] = time();
        header('Location: timeout.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>Таймаут сесії</title></head>
<body>
    <h1>Таймаут сесії (5 хв)</h1>

    <?php if ($message): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Вітаємо, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>!</p>
        <p>Остання активність: <?= date('H:i:s', $_SESSION['last_activity']) ?></p>
        <p>До автоматичного виходу залишилось: ~<?= ceil($remaining / 60) ?> хв</p>
        <p><em>Оновіть сторінку кілька разів — таймер оновлюється. Якщо не оновлювати 5 хв — сесія завершиться.</em></p>
        <a href="logout.php">🚪 Вийти</a>
    <?php else: ?>
        <p>Увійдіть, щоб почати сесію:</p>
        <form method="post">
            <input type="text" name="login" required placeholder="Ваше ім'я">
            <button type="submit">Увійти</button>
        </form>
    <?php endif; ?>
</body>
</html>