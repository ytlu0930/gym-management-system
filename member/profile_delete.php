<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

$member_id = $_SESSION["member_id"];

// 1. 刪除報名紀錄
$conn->query("DELETE FROM courseenrollment WHERE member_id=$member_id");

// 2. 刪除器材使用紀錄
$conn->query("DELETE FROM equipmentusage WHERE member_id=$member_id");

// 3. 刪除上課簽到紀錄
$conn->query("DELETE FROM attendance WHERE member_id=$member_id");

// 4. 刪除會員帳號
$conn->query("DELETE FROM Member WHERE member_id=$member_id");

// 登出所有 session
session_destroy();

echo "<script>alert('帳號已刪除'); location.href='../login.php';</script>";
?>
