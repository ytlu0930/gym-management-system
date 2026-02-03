<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";
include "template/header.php";
include "template/sidebar.php";

$sql = "SELECT A.*, M.m_name, C.course_name 
        FROM Attendance A
        JOIN Member M ON A.member_id = M.member_id
        JOIN Course C ON A.course_id = C.course_id
        ORDER BY A.attendance_time DESC";
$result = $conn->query($sql);
?>
<h2>簽到列表</h2>
<a href="attendance_add.php" class="btn btn-success mb-3">新增簽到紀錄</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>編號</th>
            <th>會員</th>
            <th>課程</th>
            <th>簽到時間</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['attendance_id'] ?></td>
            <td><?= htmlspecialchars($row['m_name']) ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['attendance_time'] ?></td>
            <td>
                <a href="attendance_edit.php?attendance_id=<?=$row['attendance_id']?>" class="btn btn-primary btn-sm">編輯</a>
                <a href="attendance_delete.php?attendance_id=<?=$row['attendance_id']?>"
                   onclick="return confirm('確定要刪除這筆紀錄嗎？');"
                   class="btn btn-danger btn-sm">刪除</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include "template/footer.php"; ?>
