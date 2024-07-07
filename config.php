<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student-course";

// 建立連線
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定連線字元集為 utf8mb4
$conn->set_charset('utf8mb4');

// 建立資料庫查詢時,也要指定使用 utf8mb4 字元集
$conn->query("SET NAMES 'utf8mb4'");
