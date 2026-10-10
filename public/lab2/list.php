<?php
$uploadDir = __DIR__ . '/uploads/';
$uploadUrl = 'uploads/';
$files = [];

if (is_dir($uploadDir)) {
    $items = scandir($uploadDir);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $uploadDir . $item;
        if (is_file($path)) {
            $files[] = [
                'name'     => $item,
                'size'     => filesize($path),
                'modified' => filemtime($path),
                'url'      => $uploadUrl . rawurlencode($item),
            ];
        }
    }

    usort($files, fn($a, $b) => $b['modified'] <=> $a['modified']);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список файлів</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #f4f4f4; }
        a.btn { display: inline-block; padding: 6px 12px; background: #007bff;
                color: #fff; text-decoration: none; border-radius: 6px; font-size: 0.9em; }
        .empty { color: #666; font-style: italic; }
    </style>
</head>
<body>
    <h1>Файли в папці uploads</h1>
    <?php if (empty($files)): ?>
        <p class="empty">Папка порожня. <a href="index.html">Завантажте файл</a>.</p>
    <?php else: ?>
        <p>Усього файлів: <strong><?= count($files) ?></strong></p>
        <table>
            <tr>
                <th>#</th>
                <th>Ім'я файлу</th>
                <th>Розмір</th>
                <th>Дата зміни</th>
                <th>Дія</th>
            </tr>
            <?php foreach ($files as $i => $f): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($f['name']) ?></td>
                    <td><?= round($f['size'] / 1024, 2) ?> КБ</td>
                    <td><?= date('Y-m-d H:i', $f['modified']) ?></td>
                    <td>
                        <a class="btn" href="<?= htmlspecialchars($f['url']) ?>" download>
                            Завантажити
                        </a>
                        <a class="btn" href="<?= htmlspecialchars($f['url']) ?>" target="_blank"
                           style="background:#28a745;">Відкрити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <hr>
    <p><a href="index.html">Назад до форми</a></p>
</body>
</html>