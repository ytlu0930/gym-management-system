<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "member") {
    header("Location: ../login.php");
    exit;
}

require_once "../connect.php";

$member_id  = $_SESSION["member_id"];
$m_name     = $_POST["m_name"];
$gender     = $_POST["gender"];
$phone      = $_POST["phone"];
$password   = $_POST["m_password"];

// 修改密碼？
if ($password != "") {
    $sql = "UPDATE Member SET m_name=?, gender=?, phone=?, m_password=? WHERE member_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $m_name, $gender, $phone, $password, $member_id);
} else {
    $sql = "UPDATE Member SET m_name=?, gender=?, phone=? WHERE member_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $m_name, $gender, $phone, $member_id);
}

$stmt->execute();

echo "<script>alert('資料更新成功'); location.href='profile.php';</script>";
?>
