<?php
// 檔案位置: admin/course_students.php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

// 檢查有沒有傳 course_id 進來
if(!isset($_GET['course_id'])){
    die("缺少課程 ID");
}

$course_id = $_GET['course_id'];

// 1. 先查出這堂課的基本資料 (標題用)
$course_sql = "SELECT course_name, course_date, course_time FROM Course WHERE course_id = ?";
$stmt = $conn->prepare($course_sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_info = $stmt->get_result()->fetch_assoc();

if(!$course_info){
    die("找不到這堂課程");
}

// 2. 查出報名這堂課的所有學生
$sql = "SELECT Member.*, CourseEnrollment.join_time
        FROM CourseEnrollment
        JOIN Member ON CourseEnrollment.member_id = Member.member_id
        WHERE CourseEnrollment.course_id = ?
        ORDER BY CourseEnrollment.join_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

include "template/header.php";
include "template/sidebar.php";
?>

<div class="container mt-4">
    <div class="alert alert-secondary border-warning border-3">
        <h3 class="mb-0">
            課程學員名單：<span class="text-primary fw-bold"><?= htmlspecialchars($course_info['course_name']) ?></span>
        </h3>
        <p class="mb-0 mt-2">
            上課時間：<?= $course_info['course_date'] ?> <?= $course_info['course_time'] ?>
        </p>
    </div>

    <div class="mb-3">
        <a href="course_list.php" class="btn btn-secondary">← 返回課程列表</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>會員 ID</th>
                <th>姓名</th>
                <th>性別</th>
                <th>電話</th>
                <th>Email</th>
                <th>報名時間</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['member_id'] ?></td>
                    <td><?= htmlspecialchars($row['m_name']) ?></td>
                    <td><?= $row['gender'] == 'male' ? '男' : '女' ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['join_time'] ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted p-4">
                        <h4>⚠️ 目前尚無學員報名</h4>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "template/footer.php"; ?>