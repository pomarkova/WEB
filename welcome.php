<?php
if (!isset($_COOKIE['User'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?= $_COOKIE['User'] ?>!</h1>
    <p>This is your protected page.</p>
    <a href="logout.php">Logout</a>
</body>
</html>