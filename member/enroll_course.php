<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION["member_id"];

if (!isset($_GET["course_id"])) {
    die("缺少課程 ID");
}

$course_id = intval($_GET["course_id"]);

// 檢查是否已經報名過
$check = $conn->prepare("SELECT * FROM CourseEnrollment WHERE member_id=? AND course_id=?");
$check->bind_param("ii", $member_id, $course_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $msg = "你已經報名過這門課程！";
} else {
    // 新增報名紀錄
    $sql = $conn->prepare("INSERT INTO CourseEnrollment (member_id, course_id) VALUES (?, ?)");
    $sql->bind_param("ii", $member_id, $course_id);

    if ($sql->execute()) {
        $msg = "報名成功！";
    } else {
        $msg = "報名失敗：" . $sql->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>報名結果</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #111;
            color: #fff;
        }
        .box {
            background: #000;
            border: 2px solid gold;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            color: gold;
        }
        .btn-gold {
            background: gold;
            color: #000;
            font-weight: bold;
            border: none;
        }
        .btn-gold:hover {
            background: #d6b300;
        }
    </style>
</head>

<body class="p-4">

<div class="box">
    <h2>報名結果</h2>
    <p><?= $msg ?></p>

    <!-- 這裡很重要：修正返回路徑 -->
    <a href="../index.php" class="btn btn-secondary">返回會員主頁</a>
</div>

</body>
</html>
