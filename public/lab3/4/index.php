<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$previousPurchases = isset($_COOKIE['previous_purchases'])
    ? json_decode($_COOKIE['previous_purchases'], true)
    : [];

if (!is_array($previousPurchases)) {
    $previousPurchases = [];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>Корзина</title></head>
<body>
    <h1>Корзина покупок</h1>

    <h2>Доступні товари</h2>
    <form action="add.php" method="post">
        <select name="product">
            <option value="Ноутбук">Ноутбук</option>
            <option value="Смартфон">Смартфон</option>
            <option value="Навушники">Навушники</option>
            <option value="Клавіатура">Клавіатура</option>
            <option value="Мишка">Мишка</option>
        </select>
        <button type="submit">Додати в корзину</button>
    </form>

    <h2>Поточна корзина</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p><em>Корзина порожня.</em></p>
    <?php else: ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Попередні покупки</h2>
    <?php if (empty($previousPurchases)): ?>
        <p><em>Попередніх покупок ще немає.</em></p>
    <?php else: ?>
        <ul>
            <?php foreach ($previousPurchases as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>
    <a href="clear.php">🗑 Очистити корзину і зберегти покупки</a>
</body>
</html>