<?php
$cacheDir  = __DIR__ . '/cache/';
$cacheFile = $cacheDir . 'report.html';
$ttl = 10 * 60;

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}
$fromCache = false;

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
    $html = file_get_contents($cacheFile);
    $fromCache = true;
} else {
    sleep(3); 

    $rows = '';
    $names = ['Олег', 'Марія', 'Іван', 'Софія', 'Петро', 'Анна', 'Богдан', 'Оксана'];
    for ($i = 1; $i <= 1000; $i++) {
        $name = $names[array_rand($names)];
        $sum  = number_format(random_int(100, 10000) / 100, 2);
        $date = date('Y-m-d', random_int(time() - 30 * 86400, time()));
        $rows .= "<tr><td>$i</td><td>$name</td><td>$sum грн</td><td>$date</td></tr>";
    }
    $html = <<<HTML
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Звіт</title>
    <style>
        body { font-family: sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 6px 10px; text-align: left; }
        th { background: #f4f4f4; position: sticky; top: 0; }
    </style>
</head>
<body>
    <h1>Звіт</h1>
    <table>
        <tr><th>#</th><th>Ім'я</th><th>Сума</th><th>Дата</th></tr>
        $rows
    </table>
</body>
</html>
HTML;
    file_put_contents($cacheFile, $html, LOCK_EX);
}
header('Content-Type: text/html; charset=utf-8');
header('X-Cache: ' . ($fromCache ? 'HIT' : 'MISS'));
echo $html;
echo "\n<!-- Джерело: " . ($fromCache ? 'кеш' : 'генерація') . " -->";