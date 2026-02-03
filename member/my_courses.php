<?php
// 檔案位置: member/my_courses.php
session_start();
require_once "connect.php"; 

if (!isset($_SESSION["member_id"])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION["member_id"];

// SQL 修正說明：
// 1. 使用 courseenrollment.enroll_id (配合資料庫與 unenroll.php)
// 2. 使用 Course.course_time (配合資料庫與 attendance.php)
$sql = "
SELECT courseenrollment.enroll_id,
       Course.course_name, 
       Course.course_date, 
       Course.course_time, 
       Coach.c_name
FROM courseenrollment
JOIN Course ON courseenrollment.course_id = Course.course_id
JOIN Coach ON Course.coach_id = Coach.coach_id
WHERE courseenrollment.member_id = ?
ORDER BY Course.course_date, Course.course_time
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL 錯誤: " . $conn->error);
}

$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>已報名課程</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#111; color:white !important; font-family: "Microsoft JhengHei", sans-serif; }
        h2 { color:gold !important; margin-bottom:20px; }
        .card { background:#000 !important; border:2px solid gold; color:white !important; }
        .card * { color:white !important; }
        .btn-secondary { background:#444; color:white !important; border:none; }
        .btn-secondary:hover { background:#666; }
        .btn-danger { background:#c82333; border:none; }
        .btn-danger:hover { background:#a71d2a; }
    </style>
</head>
<body class="p-4">

<h2>已報名課程</h2>

<a href="index.php" class="btn btn-secondary mb-3">返回會員主頁</a>

<div class="row">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-3">
                <div class="card p-3">
                    <h4><?= htmlspecialchars($row['course_name']) ?></h4>
                    <p>教練：<?= htmlspecialchars($row['c_name']) ?></p>
                    <p>日期：<?= htmlspecialchars($row['course_date']) ?></p>
                    <p>時間：<?= htmlspecialchars($row['course_time']) ?></p>

                    <a href="unenroll.php?enroll_id=<?= $row['enroll_id'] ?>"
                       class="btn btn-danger btn-sm mt-2"
                       onclick="return confirm('確定要退選這堂課程嗎？');">退選</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <p class="text-white">目前沒有報名任何課程。</p>
            <a href="courses.php" class="btn btn-outline-warning">前往選課</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>