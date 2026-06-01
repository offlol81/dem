<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'init.php';
$db = Database::getInstance()->getConnection();
$hash = password_hash('Demo20', PASSWORD_DEFAULT);
$db->prepare("INSERT INTO users (login,password,fio,phone,email,role) VALUES (?,?,?,?,?,?)")
   ->execute(array('Admin26', $hash, 'Администратор', '79999999999', 'admin@mail.ru', 'admin'));
echo "Админ создан!";