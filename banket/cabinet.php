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












<?php
require_once 'init.php';
if (!User::isLoggedIn() || User::isAdmin()) { header('Location: login.php'); exit; }

$db = Database::getInstance()->getConnection();
$review = new Review();

$reviewError = '';
$reviewSuccess = false;

// Обработка добавления отзыва
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $reviewError = $review->add($_POST['order_id'], $_SESSION['user_id'], $_POST['text']);
    if ($reviewError === null) $reviewSuccess = true;
}

$s = $db->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$s->execute(array($_SESSION['user_id']));
$orders = $s->fetchAll();
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h1>Кабинет</h1>
<p>Привет, <?php echo $_SESSION['fio']; ?>!</p>
<p><a href="order.php">+ Новая заявка</a> | <a href="logout.php">Выйти</a></p>

<div class="slider">
    <div class="slide active"><img src="https://picsum.photos/400/200?1"></div>
    <div class="slide"><img src="https://picsum.photos/400/200?2"></div>
    <div class="slide"><img src="https://picsum.photos/400/200?3"></div>
    <div class="slide"><img src="https://picsum.photos/400/200?4"></div>
    <button onclick="prevSlide()">❮</button>
    <button onclick="nextSlide()">❯</button>
</div>

<h2>Мои заявки</h2>

<?php if ($reviewSuccess): ?>
    <p class="success">Отзыв добавлен!</p>
<?php endif; ?>
<?php if ($reviewError): ?>
    <p class="error"><?php echo $reviewError; ?></p>
<?php endif; ?>

<?php if (empty($orders)): ?>
    <p>Заявок пока нет</p>
<?php else: ?>
    <?php foreach ($orders as $o): ?>
        <div class="card">
            <p>Помещение: <?php echo $o['room']; ?></p>
            <p>Дата: <?php echo $o['banquet_date']; ?></p>
            <p>Оплата: <?php echo $o['payment']; ?></p>
            <p>Статус: <b><?php echo $o['status']; ?></b></p>
            
            <?php if ($o['status'] !== 'Новая' && !$review->exists($o['id'])): ?>
                <details>
                    <summary style="cursor:pointer;color:#6C63FF;margin-top:10px;">✍️ Оставить отзыв</summary>
                    <form method="POST" style="margin-top:10px;">
                        <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                        <textarea name="text" rows="3" placeholder="Ваш отзыв..." required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;"></textarea>
                        <button>Отправить отзыв</button>
                    </form>
                </details>
            <?php elseif ($review->exists($o['id'])): ?>
                <p class="success">✓ Отзыв оставлен</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<script src="script.js"></script>
</body></html>
