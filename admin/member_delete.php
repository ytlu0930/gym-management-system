<?php
require_once "../connect.php";

if (!isset($_GET['member_id'])) {
    header("Location: member_list.php");
    exit;
}

$member_id = $_GET['member_id'];

/* 1️⃣ 先刪除該會員的課程報名紀錄 */
$sql1 = "DELETE FROM courseenrollment WHERE member_id=?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $member_id);
$stmt1->execute();

/* 2️⃣ 再刪除器材使用紀錄 */
$sql2 = "DELETE FROM equipmentusage WHERE member_id=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $member_id);
$stmt2->execute();

/* 3️⃣ 再刪除上課簽到紀錄 */
$sql3 = "DELETE FROM attendance WHERE member_id=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $member_id);
$stmt3->execute();

/* 4️⃣ 最後才能刪會員本身 */
$sql4 = "DELETE FROM Member WHERE member_id=?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param("i", $member_id);

if ($stmt4->execute()) {
    echo "<script>alert('會員與所有相關紀錄刪除成功！'); window.location.href='member_list.php';</script>";
} else {
    echo "<script>alert('刪除失敗：" . $stmt4->error . "'); window.location.href='member_list.php';</script>";
}

$stmt1->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$conn->close();
?>
