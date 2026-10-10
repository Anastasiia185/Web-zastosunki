<?php
session_start();
$ttl = 10 * 60;

$fromCache = false;

if (isset($_SESSION['cached_data']) && isset($_SESSION['cached_time'])) {
    $age = time() - $_SESSION['cached_time'];

    if ($age < $ttl) {
        $data      = $_SESSION['cached_data'];
        $fromCache = true;
        $source    = 'з кешу сесії (age: ' . $age . ' с)';
    } else {
        $data      = generateData();
        $_SESSION['cached_data'] = $data;
        $_SESSION['cached_time'] = time();
        $source    = 'кеш оновлено';
    }
} else {
    $data      = generateData();
    $_SESSION['cached_data'] = $data;
    $_SESSION['cached_time'] = time();
    $source    = 'створено новий кеш';
}

function generateData(): array
{
    sleep(2);

    return [
        'USD' => random_int(38, 45),
        'EUR' => random_int(40, 48),
        'PLN' => random_int(8, 12),
        'generated_at' => date('H:i:s'),
    ];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Session cache</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; }
        .card { padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 0.85em; }
        .hit  { background: #d4edda; color: #155724; }
        .miss { background: #fff3cd; color: #856404; }
        pre { background: #f4f4f4; padding: 12px; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>Кеш у сесії</h1>
    <div class="card">
        <p>
            Джерело даних:
            <?php if ($fromCache): ?>
                <span class="badge hit"><?= htmlspecialchars($source) ?></span>
            <?php else: ?>
                <span class="badge miss"><?= htmlspecialchars($source) ?></span>
            <?php endif; ?>
        </p>
        <h3>Курс валют:</h3>
        <pre><?= htmlspecialchars(print_r($data, true)) ?></pre>
        <p><small>Час генерації: <?= htmlspecialchars($data['generated_at']) ?></small></p>
    </div>
    <p>
        <a href="?reset=1">Очистити кеш сесії</a> |
        <a href="index.html"> Назад</a>
    </p>
    <?php
    if (isset($_GET['reset'])) {
        unset($_SESSION['cached_data'], $_SESSION['cached_time']);
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    }
    ?>
</body>
</html>