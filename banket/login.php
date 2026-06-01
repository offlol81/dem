<?php
require_once 'init.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new User();
    $error = $u->login($_POST['login'], $_POST['password']);
    if ($error === null) {
        header('Location: ' . (User::isAdmin() ? 'admin.php' : 'cabinet.php'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Вход</h1>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button>Войти</button>
    </form>
    
    <p><a href="register.php">Нет аккаунта? Регистрация</a></p>
</div>
</body>
</html>