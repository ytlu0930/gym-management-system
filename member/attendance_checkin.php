<?php
session_start();
require_once "../connect.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION["member_id"];
$course_id = $_GET["course_id"] ?? 0;

/* 先確認這堂課是會員報名的 */
$sql = "SELECT * FROM courseenrollment WHERE member_id=? AND course_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $member_id, $course_id);
$stmt->execute();
$check = $stmt->get_result();

if ($check->num_rows === 0) {
    echo "<script>alert('你沒有報名這堂課，不能簽到！');history.back();</script>";
    exit;
}

/* 防止重複簽到 */
$sql2 = "SELECT * FROM attendance WHERE member_id=? AND course_id=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ii", $member_id, $course_id);
$stmt2->execute();
$exists = $stmt2->get_result();

if ($exists->num_rows > 0) {
    echo "<script>alert('你已經簽到過了！');location.href='attendance.php';</script>";
    exit;
}

/* 新增簽到紀錄 */
$now = date("Y-m-d H:i:s");
$sql3 = "INSERT INTO attendance (member_id, course_id, check_in_time)
         VALUES (?, ?, ?)";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("iis", $member_id, $course_id, $now);
$stmt3->execute();

echo "<script>alert('簽到成功！');location.href='attendance.php';</script>";
?>
