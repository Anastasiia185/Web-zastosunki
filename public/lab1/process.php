<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Помилка: форма не була надіслана.";
    exit;
}

$firstName = trim($_POST["first_name"] ?? "");
$lastName  = trim($_POST["last_name"]  ?? "");

$errors = [];

if ($firstName === "") {
    $errors[] = "Поле 'Ім'я' не може бути порожнім.";
}
if ($lastName === "") {
    $errors[] = "Поле 'Прізвище' не може бути порожнім.";
}

if (!preg_match("/^[a-zA-Zа-яА-ЯїЇєЄіІґҐ'’\- ]+$/u", $firstName) && $firstName !== "") {
    $errors[] = "Ім'я містить недопустимі символи.";
}
if (!preg_match("/^[a-zA-Zа-яА-ЯїЇєЄіІґҐ'’\- ]+$/u", $lastName) && $lastName !== "") {
    $errors[] = "Прізвище містить недопустимі символи.";
}

if (empty($errors)) {
    echo "<h2>Вітаємо, " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "!</h2>";
    echo "<p>Раді бачити вас на нашій сторінці 👋</p>";
} else {
    echo "<h2>Помилки:</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo '<a href="index.html">← Повернутися до форми</a>';
}
?>