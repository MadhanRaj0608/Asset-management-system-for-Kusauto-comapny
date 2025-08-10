<?php
$host = 'localhost';
$db   = 'laptopdetails';
$user = 'root';      // or your hosting DB username
$pass = '';          // or your hosting DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to throw exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    die("❌ DB Connection failed: " . $e->getMessage());
}
?>
