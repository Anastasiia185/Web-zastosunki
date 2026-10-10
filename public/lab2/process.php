<?php
$uploadDir = __DIR__ . '/uploads/';
$uploadUrl = 'uploads/';

$allowedExt  = ['png', 'jpg', 'jpeg'];
$maxSize     = 2 * 1024 * 1024; 

$errors  = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors[] = 'Запит має бути методом POST.';
} elseif (!isset($_FILES['image'])) {
    $errors[] = 'Файл не передано.';
} else {
    $file = $_FILES['image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Помилка завантаження (код: ' . $file['error'] . ').';
    }
    elseif (!is_uploaded_file($file['tmp_name'])) {
        $errors[] = 'Файл не є завантаженим через HTTP POST.';
    } else {
        $originalName = $file['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = "Недозволений тип файлу: .$ext. Дозволено: " . implode(', ', $allowedExt);
        }

        if ($file['size'] > $maxSize) {
            $errors[] = 'Файл завеликий: ' . round($file['size'] / 1024, 2) . ' КБ. Максимум — 2048 КБ.';
        }

        if (empty($errors)) {
            $safeName = basename($originalName);
            $targetPath = $uploadDir . $safeName;
            if (file_exists($targetPath)) {
                $base = pathinfo($safeName, PATHINFO_FILENAME);
                $safeName = $base . '_' . date('Ymd_His') . '_' . random_int(1000, 9999) . '.' . $ext;
                $targetPath = $uploadDir . $safeName;
            }
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $success = [
                    'name'   => $safeName,
                    'type'   => $file['type'],
                    'size'   => $file['size'],
                    'path'   => $uploadUrl . $safeName,
                ];
            } else {
                $errors[] = 'Не вдалося зберегти файл у папці uploads.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результат завантаження</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; }
        .error { color: #b00020; }
        .success { color: #006400; }
        table { border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #ccc; padding: 6px 10px; }
        a.btn { display: inline-block; margin-top: 15px; padding: 8px 14px;
                background: #007bff; color: #fff; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>Результат завантаження</h1>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <h3>Помилки:</h3>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success">
            <h3>Файл успішно завантажено!</h3>
        </div>
        <table>
            <tr><th>Ім'я файлу</th>     <td><?= htmlspecialchars($success['name']) ?></td></tr>
            <tr><th>Тип</th>             <td><?= htmlspecialchars($success['type']) ?></td></tr>
            <tr><th>Розмір</th>          <td><?= round($success['size'] / 1024, 2) ?> КБ</td></tr>
        </table>
        <p>
            <a class="btn" href="<?= htmlspecialchars($success['path']) ?>" download>
                Завантажити файл назад
            </a>
        </p>
        <p><img src="<?= htmlspecialchars($success['path']) ?>" alt="preview" style="max-width: 300px; border: 1px solid #ccc;"></p>
    <?php endif; ?>
    <hr>
    <p>
        <a href="index.html">← Назад до форми</a> |
        <a href="list.php">Список усіх файлів</a>
    </p>
</body>
</html>