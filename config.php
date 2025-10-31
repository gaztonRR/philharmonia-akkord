<?php
// config.php
session_start();

$host = '127.0.0.1';
$db   = 'philharmonia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}

function is_logged_in() { return !empty($_SESSION['user']); }
function current_user() { return $_SESSION['user'] ?? null; }
function current_role() { return $_SESSION['role'] ?? 'guest'; }
function current_user_id() { return $_SESSION['user_id'] ?? null; }

function require_admin() {
    if (!is_logged_in() || current_role() !== 'admin') {
        header('Location: /philharmonia/login.php');
        exit;
    }
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: /philharmonia/login.php');
        exit;
    }
}
?>
