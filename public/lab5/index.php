<?php
require_once __DIR__ . '/AccountInterface.php';
require_once __DIR__ . '/BankAccount.php';
require_once __DIR__ . '/SavingsAccount.php';

function show(string $label, callable $fn): void
{
    echo '<li><strong>' . htmlspecialchars($label) . ':</strong> ';
    try {
        $result = $fn();
        echo htmlspecialchars((string)$result);
    } catch (Throwable $e) {
        echo '<span class="err">❌ ' . htmlspecialchars($e->getMessage()) . '</span>';
    }
    echo '</li>';
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна 5</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 40px auto; line-height: 1.5; }
        h1, h2 { color: #333; }
        .card { background: #f9f9fb; border: 1px solid #ddd; border-radius: 10px;
                padding: 16px 24px; margin-bottom: 20px; }
        ul { padding-left: 22px; }
        li { margin: 6px 0; }
        .ok  { color: #006400; }
        .err { color: #b00020; }
        code { background: #eef; padding: 2px 6px; border-radius: 4px; }
        table { border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 12px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Лабораторна робота 5</h1>

    <h2>1. Звичайний рахунок</h2>
    <div class="card">
        <?php
        $account = new BankAccount(100, 'USD');
        ?>
        <p>Створено рахунок: <code><?= $account ?></code></p>
        <ul>
            <?php
            show('Початковий баланс', fn() => $account->getBalance() . ' ' . $account->getCurrency());
            show('Поповнення на 50', function () use ($account) {
                $account->deposit(50);
                return "новий баланс: $account";
            });
            show('Зняття 30', function () use ($account) {
                $account->withdraw(30);
                return "новий баланс: $account";
            });
            show('Спроба зняти 1000 (недостатньо)', function () use ($account) {
                $account->withdraw(1000);
                return 'мало б не статися';
            });
            show('Спроба поповнити на -10 (некоректна сума)', function () use ($account) {
                $account->deposit(-10);
                return 'мало б не статися';
            });
            show('Спроба створити рахунок з балансом -5', function () {
                new BankAccount(-5, 'USD');
                return 'мало б не статися';
            });
            ?>
        </ul>
    </div>

    <h2>2. Накопичувальний рахунок</h2>
    <div class="card">
        <?php
        SavingsAccount::setInterestRate(0.10);
        $savings = new SavingsAccount(1000, 'EUR');
        ?>
        <p>Створено рахунок: <code><?= $savings ?></code></p>
        <p>Поточна ставка: <strong><?= SavingsAccount::$interestRate * 100 ?>%</strong></p>
        <ul>
            <?php
            show('Застосувати відсоток', function () use ($savings) {
                $interest = $savings->applyInterest();
                return sprintf('нараховано %s EUR, новий баланс: %s', $interest, $savings);
            });
            show('Поповнення на 500', function () use ($savings) {
                $savings->deposit(500);
                return "новий баланс: $savings";
            });
            show('Застосувати відсоток ще раз', function () use ($savings) {
                $interest = $savings->applyInterest();
                return sprintf('нараховано %s EUR, новий баланс: %s', $interest, $savings);
            });
            show('Зняти 2000 (недостатньо)', function () use ($savings) {
                $savings->withdraw(2000);
                return 'мало б не статися';
            });
            ?>
        </ul>
    </div>

    <h2>3. Поліморфізм - масив рахунків</h2>
    <div class="card">
        <?php
        $accounts = [
            new BankAccount(200, 'USD'),
            new SavingsAccount(500, 'USD'),
            new BankAccount(150, 'EUR'),
        ];
        foreach ($accounts as $acc) {
            $acc->deposit(100);
        }
        ?>
        <p>Усім рахункам поповнено по 100 одиниць:</p>
        <table>
            <tr><th>#</th><th>Клас</th><th>Баланс</th></tr>
            <?php foreach ($accounts as $i => $acc): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= get_class($acc) ?></td>
                    <td><?= $acc ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <h2>4. Демонстрація власного винятку</h2>
    <div class="card">
        <?php
        $acc = new BankAccount(50, 'USD');
        ?>
        <ul>
            <?php
            show('Зняти 100 з рахунку з балансом 50', function () use ($acc) {
                $acc->withdraw(100);
                return 'мало б не статися';
            });
            ?>
        </ul>
    </div>
</body>
</html>