<?php
require_once 'init.php';
if (!User::isLoggedIn() || User::isAdmin()) { 
    header('Location: login.php'); 
    exit; 
}

$db = Database::getInstance()->getConnection();
$s = $db->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$s->execute(array($_SESSION['user_id']));
$orders = $s->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Кабинет</h1>
    <p>Привет, <?php echo $_SESSION['fio']; ?>!</p>
    <p>
        <a href="order.php">+ Новая заявка</a> | 
        <a href="logout.php">Выйти</a>
    </p>
    
    <!-- Слайдер -->
    <div class="slider">
        <div class="slide active"><img src="https://picsum.photos/400/200?1"></div>
        <div class="slide"><img src="https://picsum.photos/400/200?2"></div>
        <div class="slide"><img src="https://picsum.photos/400/200?3"></div>
        <div class="slide"><img src="https://picsum.photos/400/200?4"></div>
        <button onclick="prevSlide()">❮</button>
        <button onclick="nextSlide()">❯</button>
    </div>
    
    <h2>Мои заявки</h2>
    
    <?php if (empty($orders)): ?>
        <p>Заявок пока нет</p>
    <?php else: ?>
        <?php foreach ($orders as $o): ?>
            <div class="card">
                <p>Помещение: <?php echo $o['room']; ?></p>
                <p>Дата: <?php echo $o['banquet_date']; ?></p>
                <p>Оплата: <?php echo $o['payment']; ?></p>
                <p>Статус: <b><?php echo $o['status']; ?></b></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="script.js"></script>
</body>
</html>