<?php
require_once 'init.php';
if (!User::isLoggedIn() || User::isAdmin()) { 
    header('Location: login.php'); 
    exit; 
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $db->prepare("INSERT INTO orders (user_id,room,banquet_date,payment) VALUES (?,?,?,?)")
       ->execute(array(
           $_SESSION['user_id'], 
           $_POST['room'], 
           $_POST['banquet_date'], 
           $_POST['payment']
       ));
    $success = true;
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
    <h1>Новая заявка</h1>
    <p><a href="cabinet.php">← В кабинет</a></p>
    
    <?php if ($success): ?>
        <p class="success">Заявка отправлена!</p>
    <?php endif; ?>
    
    <form method="POST">
        <select name="room" required>
            <option value="">— Помещение —</option>
            <option>Зал</option>
            <option>Ресторан</option>
            <option>Летняя веранда</option>
            <option>Закрытая веранда</option>
        </select>
        
        <input type="date" name="banquet_date" required>
        
        <select name="payment" required>
            <option value="">— Способ оплаты —</option>
            <option>Наличные</option>
            <option>Карта</option>
            <option>Онлайн</option>
        </select>
        
        <button>Отправить</button>
    </form>
</div>
</body>
</html>