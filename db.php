<?php
$host = 'localhost';
$dbname = 'nsbm_news_db';
$username = 'root'; // default XAMPP username
$password = '';     // default XAMPP password (blank)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>