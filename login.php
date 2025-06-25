<?php
session_start();
require 'config.php';

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('user', '', time() - 3600, '/');
    header('Location: login.php');
    exit;
}

// вход
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        setcookie('user', $user['username'], time() + 3600, '/');
        header('Location: welcome.php');
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
</head>
<body>
    <h1>Вход</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['username'])): ?>
        <p>Вы уже авторизованы как <?php echo $_SESSION['username']; ?></p>
        <a href="welcome.php">Приветственная страница</a><br>
        <a href="login.php?logout=1">Выйти</a>
    <?php else: ?>
        <form method="post">
            <label>Имя пользователя:</label>
            <input type="text" name="username" required><br>
            <label>Пароль:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Войти</button>
        </form>
        <a href="register.php">Регистрация</a>
    <?php endif; ?>
</body>
</html>