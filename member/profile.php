<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

$member_id = $_SESSION["member_id"];

// 取目前會員資料
$sql = "SELECT * FROM Member WHERE member_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>個人資料</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#111; color:white; }
        .box { background:#000; border:2px solid gold; padding:20px; border-radius:10px; }
        h2 { color:gold; }
        label { color:gold; }
        .btn-gold { background:gold; color:black; font-weight:bold; border:none; }
        .btn-gold:hover { background:#e8c200; }
    </style>
</head>

<body class="p-4">

<div class="box">
    <h2>個人資料</h2>
    <form action="profile_update.php" method="POST">

        <div class="mb-3">
            <label>姓名</label>
            <input type="text" name="m_name" class="form-control" value="<?= htmlspecialchars($profile['m_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>性別</label>
            <select name="gender" class="form-select">
                <option value="male"   <?= $profile['gender']=='male' ? 'selected' : '' ?>>男</option>
                <option value="female" <?= $profile['gender']=='female' ? 'selected' : '' ?>>女</option>
            </select>
        </div>

        <div class="mb-3">
            <label>電話</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($profile['phone']) ?>">
        </div>

        <div class="mb-3">
            <label>Email（不可修改）</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($profile['email']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label>修改密碼（留空則不變）</label>
            <input type="password" name="m_password" class="form-control">
        </div>

        <button class="btn btn-gold">儲存變更</button>
        <a href="../index.php" class="btn btn-secondary">返回會員首頁</a>
        <a href="profile_delete.php" class="btn btn-danger float-end"
           onclick="return confirm('確定要刪除帳號？此動作無法復原！');">刪除帳號</a>
    </form>
</div>

</body>
</html>
