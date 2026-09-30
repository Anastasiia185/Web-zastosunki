<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head><meta charset="UTF-8"><title>SERVER</title></head>
    <body>
        <p>Щоб побачити інформацію про сервер і запит, надішліть форму нижче:</p>

        <form method="post">
            <label>Ваше ім'я: <input type="text" name="name" required></label>
            <button type="submit">Показати інформацію</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

$name = htmlspecialchars($_POST['name'] ?? '');

$data = [
    'IP-адреса клієнта'        => $_SERVER['REMOTE_ADDR'] ?? '—',
    'User Agent (браузер)'      => $_SERVER['HTTP_USER_AGENT'] ?? '—',
    'Назва скрипта (PHP_SELF)'  => $_SERVER['PHP_SELF'] ?? '—',
    'Метод запиту'              => $_SERVER['REQUEST_METHOD'] ?? '—',
    'Шлях до файлу на сервері'  => $_SERVER['SCRIPT_FILENAME'] ?? '—',
    'Ім\'я хоста'               => $_SERVER['SERVER_NAME'] ?? '—',
    'Порт сервера'              => $_SERVER['SERVER_PORT'] ?? '—',
    'Протокол'                  => $_SERVER['SERVER_PROTOCOL'] ?? '—',
];
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>$_SERVER — результат</title></head>
<body>
    <h1>Привіт, <?= $name ?>!</h1>
    <h2>Інформація з $_SERVER</h2>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr><th>Параметр</th><th>Значення</th></tr>
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td><?= htmlspecialchars($key) ?></td>
                <td><?= htmlspecialchars($value) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="server.php">← Повернутися</a></p>
</body>
</html>