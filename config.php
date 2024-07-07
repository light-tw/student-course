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