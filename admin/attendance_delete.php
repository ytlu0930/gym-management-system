<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

if (!isset($_GET['attendance_id'])) {
    header("Location: attendance_list.php");
    exit;
}

$attendance_id = (int)$_GET['attendance_id'];

$stmt = $conn->prepare("DELETE FROM Attendance WHERE attendance_id=?");
$stmt->bind_param("i", $attendance_id);

if ($stmt->execute()) {
    echo "<script>alert('簽到紀錄刪除成功');location.href='attendance_list.php';</script>";
} else {
    echo "<script>alert('刪除失敗：" . $stmt->error . "');location.href='attendance_list.php';</script>";
}
?>
