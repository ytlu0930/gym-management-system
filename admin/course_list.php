<?php
// 檔案位置: admin/course_list.php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php"; 

// 顯示所有課程 (包含教練名字)
$sql = "SELECT Course.*, Coach.c_name 
        FROM Course 
        JOIN Coach ON Course.coach_id = Coach.coach_id 
        ORDER BY Course.course_date DESC, Course.course_time ASC";
$result = $conn->query($sql);

include "template/header.php";
include "template/sidebar.php";
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>課程管理</h2>
        <a href="course_add.php" class="btn btn-warning text-dark fw-bold rounded-0">＋ 新增課程</a>
    </div>

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>編號</th>
                <th>課程名稱</th>
                <th>教練</th>
                <th>日期</th>
                <th>時間</th>
                <th>地點</th>
                <th style="width: 280px;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['course_id'] ?></td>
                    <td class="fw-bold"><?= htmlspecialchars($row['course_name']) ?></td>
                    <td><?= htmlspecialchars($row['c_name']) ?></td>
                    <td><?= $row['course_date'] ?></td>
                    <td><?= $row['course_time'] ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="course_students.php?course_id=<?= $row['course_id'] ?>" 
                               class="btn btn-info btn-sm text-white rounded-0">
                               名單  |
                            </a>
                            
                            <a href="course_edit.php?course_id=<?= $row['course_id'] ?>" 
                               class="btn btn-primary btn-sm rounded-0">
                               編輯  |
                            </a>
                            
                            <a href="course_delete.php?course_id=<?= $row['course_id'] ?>" 
                               class="btn btn-danger btn-sm rounded-0"
                               onclick="return confirm('確定要刪除這堂課嗎？');">
                               刪除
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">目前沒有課程</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "template/footer.php"; ?>