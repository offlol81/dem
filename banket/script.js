let c = 0;

function show(n) {
    const s = document.querySelectorAll('.slide');
    if (!s.length) return;
    s[c].classList.remove('active');
    c = (n + s.length) % s.length;
    s[c].classList.add('active');
}

function nextSlide() { show(c + 1); }
function prevSlide() { show(c - 1); }

setInterval(nextSlide, 3000);





<?php
class Review {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function add($orderId, $userId, $text) {
        if (empty(trim($text))) return 'Введите текст отзыва';
        
        // Проверяем статус заявки
        $s = $this->db->prepare("SELECT status FROM orders WHERE id=?");
        $s->execute(array($orderId));
        $order = $s->fetch();
        
        if (!$order || $order['status'] === 'Новая') 
            return 'Отзыв можно оставить только после обработки заявки';
        
        // Проверяем нет ли уже отзыва
        $s = $this->db->prepare("SELECT id FROM reviews WHERE order_id=?");
        $s->execute(array($orderId));
        if ($s->fetch()) return 'Вы уже оставили отзыв';
        
        $s = $this->db->prepare("INSERT INTO reviews (order_id,user_id,text) VALUES (?,?,?)");
        $s->execute(array($orderId, $userId, $text));
        return null;
    }
    
    public function exists($orderId) {
        $s = $this->db->prepare("SELECT id FROM reviews WHERE order_id=?");
        $s->execute(array($orderId));
        return (bool)$s->fetch();
    }
}
