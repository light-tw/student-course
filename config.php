<?php
$servername = "localhost";
$username = "你的資料庫使用者名稱";
$password = "你的資料庫密碼";
$database = "student_course_system";

// 建立連線
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}