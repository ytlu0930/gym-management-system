<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("
    SELECT * FROM EquipmentUsage 
    WHERE member_id=? 
    ORDER BY start_time DESC
");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$data = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>器材使用紀錄</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<style>
    body{ background:#111; color:white; }
    .box{ padding:20px; border:2px solid #f5c400; border-radius:10px; margin-bottom:15px; }
</style>
</head>

<body class="p-4">
<h2>器材使用紀錄</h2>

<?php while($r = $data->fetch_assoc()): ?>
<div class="box">
    <p><strong>器材名稱：</strong><?= $r["equipment_name"] ?></p>
    <p><strong>開始時間：</strong><?= $r["start_time"] ?></p>
    <p><strong>結束時間：</strong><?= $r["end_time"] ?></p>
</div>
<?php endwhile; ?>

<a href="../index.php" class="btn btn-secondary mb-3">返回會員主頁</a>


</body>
</html>
