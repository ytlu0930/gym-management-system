<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";
include "template/header.php";
include "template/sidebar.php";

// 修正 SQL：確保欄位名稱跟資料庫一模一樣
$sql = "SELECT CE.*, M.m_name, C.course_name, C.course_date, C.course_time
        FROM CourseEnrollment CE
        JOIN Member M ON CE.member_id = M.member_id
        JOIN Course C ON CE.course_id = C.course_id
        ORDER BY CE.join_time DESC";

$result = $conn->query($sql);

// ⚠️ 關鍵修正：如果 SQL 失敗，這行會直接告訴你原因！
if (!$result) {
    die("<h3 style='color:red'>讀取失敗，請截圖給我看：<br>" . $conn->error . "</h3>");
}
?>

<h2>課程加入紀錄</h2>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>編號</th>
            <th>會員</th>
            <th>課程名稱</th>
            <th>日期</th>
            <th>時間</th>
            <th>加入時間</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['enroll_id'] ?></td>
            <td><?= htmlspecialchars($row['m_name']) ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['course_date'] ?></td>
            <td><?= $row['course_time'] ?></td>
            <td><?= $row['join_time'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include "template/footer.php"; ?>