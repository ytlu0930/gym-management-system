<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$sql = "
SELECT Course.*, Coach.c_name
FROM Course
JOIN Coach ON Course.coach_id = Coach.coach_id
ORDER BY course_date, course_time
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>可報名課程</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background:#111; 
            color:#fff;             /* 全部白字 */
        }
        h2 { 
            color: gold; 
        }
        .card { 
            background:#000; 
            border:2px solid gold; 
            color:#fff;            /* 卡片內文字白色 */
        }
        .btn-gold {
            background: gold;
            color: #000;
            font-weight: bold;
            border: none;
        }
        .btn-gold:hover {
            background: #e0c200;
        }
    </style>
</head>

<body class="p-4">

<h2>可報名課程</h2>

<!-- 返回會員主頁：從 member/ 回到根目錄 index.php -->
<a href="../index.php" class="btn btn-secondary mb-3">返回會員主頁</a>

<div class="row">

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
        <div class="card p-3">
            <h4><?= htmlspecialchars($row['course_name']) ?></h4>
            <p>教練：<?= htmlspecialchars($row['c_name']) ?></p>
            <p>日期：<?= $row['course_date'] ?></p>
            <p>時間：<?= $row['course_time'] ?></p>
            <p>地點：<?= htmlspecialchars($row['location']) ?></p>

            <a href="enroll_course.php?course_id=<?= $row['course_id'] ?>" 
               class="btn btn-gold">報名</a>
        </div>
    </div>
<?php endwhile; ?>

</div>

</body>
</html>
