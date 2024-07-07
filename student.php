<?php
include 'config.php';

// 新增學生
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    $name = $_POST["name"];
    $studentID = $_POST["studentID"];
    // 其他欄位...

    $sql = "INSERT INTO Student (name, studentID, ...) VALUES ('$name', '$studentID', ...)";
    if ($conn->query($sql) === TRUE) {
        echo "新增學生成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 刪除學生
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "delete") {
    $studentID = $_POST["studentID"];

    $sql = "DELETE FROM Student WHERE studentID='$studentID'";
    if ($conn->query($sql) === TRUE) {
        echo "刪除學生成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 獲取學生列表
$sql = "SELECT * FROM Student";
$result = $conn->query($sql);

// 顯示學生列表
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>姓名</th><th>學號</th>...</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["studentID"] . "</td>";
        // 其他欄位...
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "沒有學生資料";
}

$conn->close();
?>