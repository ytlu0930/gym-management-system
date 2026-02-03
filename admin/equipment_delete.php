<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

if (!isset($_GET['usage_id'])) {
    header("Location: equipment_list.php");
    exit;
}

$usage_id = (int)$_GET['usage_id'];

$stmt = $conn->prepare("DELETE FROM EquipmentUsage WHERE usage_id=?");
$stmt->bind_param("i", $usage_id);

if ($stmt->execute()) {
    echo "<script>alert('紀錄刪除成功');location.href='equipment_list.php';</script>";
} else {
    echo "<script>alert('刪除失敗：" . $stmt->error . "');location.href='equipment_list.php';</script>";
}
?>
