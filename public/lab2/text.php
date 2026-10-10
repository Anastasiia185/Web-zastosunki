<?php
$logFile = __DIR__ . '/log.txt';
$messages = [];
$justWritten = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['message'] ?? ''))) {
    $msg = trim($_POST['message']);
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
    if (file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX) !== false) {
        $justWritten = $msg;
    }
}
if (file_exists($logFile)) {
    $messages = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $messages = array_reverse($messages);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>log.txt</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; }
        .success { color: #006400; }
        .log { background: #f4f4f4; padding: 15px; border-radius: 8px; white-space: pre-wrap;
               font-family: monospace; max-height: 400px; overflow-y: auto; }
        a.btn { display: inline-block; margin-top: 15px; padding: 8px 14px;
                background: #007bff; color: #fff; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>Робота з log.txt</h1>
    <?php if ($justWritten !== null): ?>
        <p class="success">Записано: <em><?= htmlspecialchars($justWritten) ?></em></p>
    <?php endif; ?>
    <h2>Вміст файлу (<?= count($messages) ?> записів)</h2>
    <?php if (empty($messages)): ?>
        <p><em>Файл порожній або ще не створений.</em></p>
    <?php else: ?>
        <div class="log"><?php
            foreach ($messages as $line) {
                echo htmlspecialchars($line) . "\n";
            }
        ?></div>
    <?php endif; ?>
    <hr>
    <p>
        <a class="btn" href="index.html">До форми</a>
        <a class="btn" href="list.php">Список файлів</a>
    </p>
</body>
</html>