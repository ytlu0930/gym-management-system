<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION["member_id"];

/* 查詢會員所有已報名課程 (含是否簽到) */
$sql = "
SELECT Course.course_id, Course.course_name, Course.course_date, Course.course_time,
       attendance.check_in_time
FROM courseenrollment
JOIN Course ON courseenrollment.course_id = Course.course_id
LEFT JOIN attendance 
       ON attendance.course_id = Course.course_id 
      AND attendance.member_id = courseenrollment.member_id
WHERE courseenrollment.member_id = ?
ORDER BY Course.course_date, Course.course_time
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang='zh-TW'>
<head>
    <meta charset='UTF-8'>
    <title>上課簽到</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>

    <style>
        body { background:#111; color:#fff; }
        h2 { color: gold; }
        .card { background:#000; border:2px solid gold; color:white; }
        .card * { color:white !important; }
        .btn-gold { background:gold; color:black; font-weight:bold; }
        .btn-gold:hover { background:#e0c200; }
    </style>
</head>

<body class='p-4'>

<h2>上課簽到</h2>
<a href="../index.php" class="btn btn-secondary mb-3">返回會員主頁</a>

<div class="row">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
        <div class="card p-3">

            <h4><?= $row['course_name'] ?></h4>
            <p>日期：<?= $row['course_date'] ?></p>
            <p>時間：<?= $row['course_time'] ?></p>

            <?php if ($row['check_in_time']): ?>
                <p>✔ 已簽到：<br><?= $row['check_in_time'] ?></p>
            <?php else: ?>
                <a href="attendance_checkin.php?course_id=<?= $row['course_id'] ?>"
                   class="btn btn-gold"
                   onclick="return confirm('確認要簽到？');">立即簽到</a>
            <?php endif; ?>

        </div>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>
