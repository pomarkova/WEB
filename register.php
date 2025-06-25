<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Базовые проверки и очистка
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Все поля обязательны для заполнения";
    } else {
        try {
            // Проверка существования пользователя
            $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $check->execute([$username]);
            
            if ($check->rowCount() > 0) {
                $error = "Пользователь с таким именем уже существует";
            } else {
                // Создание пользователя
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hashedPassword]);
                
                // Автоматический вход после регистрации
                session_start();
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                
                header('Location: profile.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = "Ошибка регистрации: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 8px; 
            box-sizing: border-box; 
        }
        .error { color: red; margin-bottom: 15px; }
        .btn { 
            padding: 10px 15px; 
            background: #007bff; 
            color: white; 
            border: none; 
            cursor: pointer; 
        }
        .links { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <h1>Регистрация</h1>
    
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" 
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
    
    <div class="links">
        <a href="login.php">Уже есть аккаунт? Войти</a>
    </div>
</body>
</html>