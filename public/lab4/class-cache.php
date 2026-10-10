<?php

class DataProvider
{
    private static ?array $cache = null;
    private static ?int   $cachedAt = null;
    private const TTL = 300; 

    public static function getData(): array
    {
        if (self::$cache !== null && (time() - self::$cachedAt) < self::TTL) {
            return self::$cache;
        }
        sleep(2);

        self::$cache    = [
            'users' => ['Олег', 'Марія', 'Іван'],
            'total' => random_int(100, 999),
            'at'    => date('H:i:s'),
        ];
        self::$cachedAt = time();

        return self::$cache;
    }
}

$start = microtime(true);
$data  = DataProvider::getData();
$time1 = round((microtime(true) - $start) * 1000);

$start = microtime(true);
$data2 = DataProvider::getData();
$time2 = round((microtime(true) - $start) * 1000);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кеш у класі</title>
    <style>body{font-family:sans-serif;max-width:600px;margin:40px auto;} pre{background:#f4f4f4;padding:12px;border-radius:6px;}</style>
</head>
<body>
    <h1>Кеш через статичну властивість класу</h1>
    <p>Перший виклик: <strong><?= $time1 ?> мс</strong></p>
    <p>Другий виклик (з кешу): <strong><?= $time2 ?> мс</strong></p>
    <pre><?= htmlspecialchars(print_r($data, true)) ?></pre>
    <p><small><em>Кеш живе лише в межах одного запиту — при F5 статичні властивості скидаються.</em></small></p>
    <p><a href="index.html">Назад</a></p>
</body>
</html>