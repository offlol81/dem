<?php
require_once 'init.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Банкетам.Нет</h1>
    <p style="text-align:center; color:#777; margin-bottom:15px;">
        Бронирование помещений для банкетов
    </p>   
    <!-- Кнопки -->
    <?php if (User::isLoggedIn()): ?>
        <?php if (User::isAdmin()): ?>
            <a href="admin.php"><button>Панель администратора</button></a>
        <?php else: ?>
            <a href="cabinet.php"><button>Личный кабинет</button></a>
            <a href="order.php"><button>Новая заявка</button></a>
        <?php endif; ?>
        <a href="logout.php"><button style="background:#888;">Выйти</button></a>
    <?php else: ?>
        <a href="register.php"><button>Регистрация</button></a>
        <a href="login.php"><button style="background:#888;">Вход</button></a>
    <?php endif; ?>
</div>
<script src="script.js"></script>
</body>
</html>
