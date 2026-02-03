<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

if (!isset($_GET['course_id'])) {
    header("Location: course_list.php");
    exit;
}

$course_id = (int)$_GET['course_id'];

/* 1️⃣ 刪除該課程的報名紀錄 */
$sql1 = "DELETE FROM courseenrollment WHERE course_id=?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $course_id);
$stmt1->execute();

/* 2️⃣ 刪除該課程的簽到紀錄 */
$sql2 = "DELETE FROM attendance WHERE course_id=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $course_id);
$stmt2->execute();

/* 3️⃣ 最後刪除課程 */
$sql3 = "DELETE FROM Course WHERE course_id=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $course_id);

if ($stmt3->execute()) {
    echo "<script>alert('課程以及相關紀錄刪除成功');location.href='course_list.php';</script>";
} else {
    echo "<script>alert('刪除失敗：" . $stmt3->error . "');location.href='course_list.php';</script>";
}
?>
