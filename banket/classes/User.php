<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function register($login, $pass, $fio, $phone, $email) {
        if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $login)) 
            return 'Логин: латиница и цифры, минимум 6 символов';
        if (strlen($pass) < 8) 
            return 'Пароль: минимум 8 символов';
        if (empty($fio) || empty($phone) || empty($email)) 
            return 'Заполните все поля';
        
        $s = $this->db->prepare("SELECT id FROM users WHERE login=?");
        $s->execute(array($login));
        if ($s->fetch()) return 'Логин уже занят';
        
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $s = $this->db->prepare("INSERT INTO users (login,password,fio,phone,email) VALUES (?,?,?,?,?)");
        $s->execute(array($login, $hash, $fio, $phone, $email));
        return null;
    }
    
    public function login($login, $pass) {
        $s = $this->db->prepare("SELECT * FROM users WHERE login=?");
        $s->execute(array($login));
        $u = $s->fetch();
        
        if (!$u) return 'Логин не найден';
        if (!password_verify($pass, $u['password'])) return 'Неверный пароль';
        
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['fio'] = $u['fio'];
        $_SESSION['role'] = $u['role'];
        return null;
    }
    
    public static function isLoggedIn() { 
        return isset($_SESSION['user_id']); 
    }
    
    public static function isAdmin() { 
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; 
    }
}