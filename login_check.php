<?php
session_start();
require_once "connect.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    $_SESSION['login_error'] = "請輸入帳號與密碼";
    header("Location: login.php");
    exit;
}

/* 先查教練（管理員） */
$sql = "SELECT * FROM Coach WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $admin = $res->fetch_assoc();

    // ⭐ 明文比對（不用 password_verify）
    if ($password === $admin['c_password']) {
        $_SESSION['admin_id'] = $admin['coach_id'];
        $_SESSION['admin_name'] = $admin['c_name'];
        $_SESSION['role'] = "admin";
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $_SESSION['login_error'] = "管理員密碼錯誤";
        header("Location: login.php");
        exit;
    }
}

/* 再查會員 */
$sql2 = "SELECT * FROM Member WHERE email = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("s", $email);
$stmt2->execute();
$res2 = $stmt2->get_result();

if ($res2->num_rows > 0) {
    $member = $res2->fetch_assoc();

    // ⭐ 明文比對
    if ($password === $member['m_password']) {
        $_SESSION['member_id'] = $member['member_id'];
        $_SESSION['member_name'] = $member['m_name'];
        $_SESSION['role'] = "member";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "會員密碼錯誤";
        header("Location: login.php");
        exit;
    }
}

/* 找不到帳號 */
$_SESSION['login_error'] = "帳號不存在";
header("Location: login.php");
exit;
?>
