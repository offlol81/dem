<?php
require_once 'init.php';
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new User();
    $error = $u->register(
        $_POST['login'], 
        $_POST['password'], 
        $_POST['fio'], 
        $_POST['phone'], 
        $_POST['email']
    );
    if ($error === null) $success = true;
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
    <h1>Регистрация</h1>
    
    <?php if ($success): ?>
        <p class="success">Готово! <a href="login.php">Войти</a></p>
    <?php else: ?>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <input name="login" placeholder="Логин (6+ символов)" required>
            <input type="password" name="password" placeholder="Пароль (8+ символов)" required>
            <input name="fio" placeholder="ФИО" required>
            <input name="phone" placeholder="Телефон" required>
            <input type="email" name="email" placeholder="Email" required>
            <button>Зарегистрироваться</button>
        </form>
    <?php endif; ?>
    
    <p><a href="login.php">Уже есть аккаунт? Войти</a></p>
</div>
</body>
</html>