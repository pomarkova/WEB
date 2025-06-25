<?php
session_start(); // Добавляем сессии для более безопасной аутентификации

// Проверяем авторизацию по куки И по сессии
if (!isset($_COOKIE['User']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Получаем имя пользователя безопасным способом
$username = $_SESSION['username'] ?? htmlspecialchars($_COOKIE['User']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .welcome-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome, <?= $username ?>!</h1>
        <p>This is your protected content.</p>
        <p>You have successfully accessed the secure area.</p>
        
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>