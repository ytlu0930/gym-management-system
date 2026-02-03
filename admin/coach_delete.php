<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

if (!isset($_GET['coach_id'])) {
    header("Location: coach_list.php");
    exit;
}

$coach_id = (int)$_GET['coach_id'];

/* 1️⃣ 找出該教練底下所有課程 */
$sql_courses = "SELECT course_id FROM Course WHERE coach_id=?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $coach_id);
$stmt_courses->execute();
$result = $stmt_courses->get_result();

while ($course = $result->fetch_assoc()) {

    $course_id = $course['course_id'];

    /* 2️⃣ 刪除該課程的報名紀錄 */
    $sql_enroll = "DELETE FROM courseenrollment WHERE course_id=?";
    $stmt_enroll = $conn->prepare($sql_enroll);
    $stmt_enroll->bind_param("i", $course_id);
    $stmt_enroll->execute();

    /* 3️⃣ 刪除簽到紀錄 */
    $sql_att = "DELETE FROM attendance WHERE course_id=?";
    $stmt_att = $conn->prepare($sql_att);
    $stmt_att->bind_param("i", $course_id);
    $stmt_att->execute();

    /* 4️⃣ 刪除課程本身 */
    $sql_course_del = "DELETE FROM Course WHERE course_id=?";
    $stmt_course_del = $conn->prepare($sql_course_del);
    $stmt_course_del->bind_param("i", $course_id);
    $stmt_course_del->execute();
}

/* 5️⃣ 最後刪除教練 */
$sql = "DELETE FROM Coach WHERE coach_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $coach_id);

if ($stmt->execute()) {
    echo "<script>alert('教練與所有相關課程已成功刪除');location.href='coach_list.php';</script>";
} else {
    echo "<script>alert('刪除失敗：" . $stmt->error . "');location.href='coach_list.php';</script>";
}

?>
