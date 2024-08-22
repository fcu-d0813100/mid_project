<?php
$host = 'localhost';
$dbname = 'mid_project';
$username = 'admin';  // 根據你的設置
$password = '12345';      // 根據你的設置

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "連線成功";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
