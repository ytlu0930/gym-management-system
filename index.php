<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員專區</title>

    <!-- 🔥 套用你的黑金共用 CSS -->
    <link rel="stylesheet" href="assets/style_member.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="box">
        <h2>會員專區</h2>
        <p>歡迎，<b style="color:gold;"><?php echo $_SESSION["member_name"]; ?></b>！</p>

        <hr style="border-color: gold;">

        <h4 style="color:gold;">可使用功能：</h4>
        <ul>
            <li><a href="member/profile.php" style="color:gold;">查看個人資料</a></li>
            <li><a href="member/courses.php" style="color:gold;">查看可報名課程</a></li>
            <li><a href="member/my_courses.php" style="color:gold;">查看已報名課程</a></li>
            <li><a href="member/equipment_usage.php" style="color:gold;">查看器材使用紀錄</a></li>
            <li><a href="member/attendance.php" style="color:gold;">查看上課簽到紀錄</a></li>
        </ul>
        <a href="logout.php" class="btn btn-gold mt-3">登出</a>
    </div>

</body>
</html>
