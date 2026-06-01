<?php
require_once 'init.php';
if (!User::isAdmin()) { 
    header('Location: login.php'); 
    exit; 
}

$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->prepare("UPDATE orders SET status=? WHERE id=?")
       ->execute(array($_POST['status'], $_POST['id']));
    header('Location: admin.php');
    exit;
}

$orders = $db->query(
    "SELECT o.*, u.fio FROM orders o 
     JOIN users u ON o.user_id=u.id 
     ORDER BY o.id DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Админ</h1>
    <p><a href="logout.php">Выйти</a></p>
    
    <?php if (empty($orders)): ?>
        <p>Заявок нет</p>
    <?php else: ?>
        <?php foreach ($orders as $o): ?>
            <div class="card">
                <p>Клиент: <?php echo $o['fio']; ?></p>
                <p>Помещение: <?php echo $o['room']; ?></p>
                <p>Дата: <?php echo $o['banquet_date']; ?></p>
                <p>Оплата: <?php echo $o['payment']; ?></p>
                <p>Статус: <b><?php echo $o['status']; ?></b></p>
                
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                    <select name="status">
                        <option>Новая</option>
                        <option>Банкет назначен</option>
                        <option>Банкет завершен</option>
                    </select>
                    <button>Сохранить</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>