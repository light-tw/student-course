<?php
include 'config.php';

// 新增學生
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    $name = $_POST["name"];
    $studentID = $_POST["studentID"];
    $department = $_POST["department"];
    $class = $_POST["class"];
    $gender = $_POST["gender"];
    $birthDate = $_POST["birthDate"];

    $sql = "INSERT INTO Student (name, studentID, departmentID, class, gender, birthDate) 
            VALUES ('$name', '$studentID', (SELECT departmentID FROM Department WHERE departmentName = '$department'), '$class', '$gender', '$birthDate')";
    if ($conn->query($sql) === TRUE) {
        echo "新增學生成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 獲取學生列表
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * 20;
$sql = "SELECT s.name, s.studentID, d.departmentName, s.class, s.gender, s.birthDate 
        FROM Student s
        JOIN Department d ON s.departmentID = d.departmentID
        ORDER BY s.studentID
        LIMIT $start, 20";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生資料</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.html">學生選課系統</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">首頁</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="students.php">學生資料</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="courses.php">課程資料</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registrations.php">選課紀錄</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-5">
        <h1>學生資料</h1>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStudentModal">
            新增學生
        </button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>學號</th>
                    <th>科系</th>
                    <th>班級</th>
                    <th>性別</th>
                    <th>生日</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["studentID"] . "</td>";
                        echo "<td>" . $row["departmentName"] . "</td>";
                        echo "<td>" . $row["class"] . "</td>";
                        echo "<td>" . $row["gender"] . "</td>";
                        echo "<td>" . $row["birthDate"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>沒有學生資料</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // 分頁
        $sql = "SELECT COUNT(*) as total FROM Student";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total = $row['total'];
        $pages = ceil($total / 20);

        echo "<nav aria-label='Page navigation'>";
        echo "<ul class='pagination justify-content-center'>";

        for ($i = 1; $i <= $pages; $i++) {
            echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='students.php?page=$i'>$i</a></li>";
        }

        echo "</ul>";
        echo "</nav>";
        ?>
    </div>

    <!-- 新增學生 Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">新增學生</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="students.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="studentID">學號</label>
                            <input type="text" class="form-control" id="studentID" name="studentID" required>
                        </div>
                        <div class="form-group">
                            <label for="department">科系</label>
                            <select class="form-control" id="department" name="department" required>
                                <?php
                                $sql = "SELECT departmentName FROM Department";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["departmentName"] . "'>" . $row["departmentName"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class">班級</label>
                            <input type="text" class="form-control" id="class" name="class" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">性別</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthDate">生日 (西元年/月/日)</label>
                            <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary" name="action" value="add">新增</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 