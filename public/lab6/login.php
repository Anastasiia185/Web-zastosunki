<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 40px auto; }
        input { width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box; }
        button { padding: 10px; width: 100%; cursor: pointer; background: #28a745; color: white; border: none; border-radius: 4px;}
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Вхід</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label>Ім'я користувача:</label>
        <input type="text" name="username" required>
        
        <label>Пароль:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Увійти</button>
    </form>
    
    <p>Немає акаунту? <a href="index.php">Зареєструватися</a></p>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db.php';
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: login.php?error=' . urlencode('Заповніть усі поля'));
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: welcome.php');
            exit;
        } else {
            header('Location: login.php?error=' . urlencode('Невірне ім\'я користувача або пароль'));
            exit;
        }
    } catch (PDOException $e) {
        header('Location: login.php?error=' . urlencode('Помилка бази даних'));
        exit;
    }
}
?>