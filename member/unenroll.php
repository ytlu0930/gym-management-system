<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION["member_id"];
$enroll_id = $_GET["enroll_id"] ?? 0;

// 安全檢查：只能退選自己的課
$sql = "DELETE FROM courseenrollment WHERE enroll_id=? AND member_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $enroll_id, $member_id);

if ($stmt->execute()) {
    echo "<script>alert('已成功退選課程'); location.href='my_courses.php';</script>";
} else {
    echo "<script>alert('退選失敗'); location.href='my_courses.php';</script>";
}
?>
