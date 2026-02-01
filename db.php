<?php
$host = "localhost";
$user = "root";
$pass = "doanh2005";
$db = "dapp_2fa";

$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// Create table if not exists
$table_sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    wallet_address VARCHAR(100) NOT NULL
)";
$conn->query($table_sql);

if (!isset($_SESSION)) {
    session_start();
}
?>
