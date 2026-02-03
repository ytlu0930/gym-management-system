<?php
require_once "../connect.php";

if (!isset($_GET['member_id'])) {
    header("Location: member_list.php");
    exit;
}

$member_id = $_GET['member_id'];

$stmt = $conn->prepare("SELECT * FROM Member WHERE member_id=?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $m_name = $_POST['m_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password_input = $_POST['m_password'];

    if (!empty($password_input)) {
        $sql = "UPDATE Member SET m_name=?, gender=?, phone=?, email=?, m_password=? WHERE member_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $m_name, $gender, $phone, $email, $password_input, $member_id);
    } else {
        $sql = "UPDATE Member SET m_name=?, gender=?, phone=?, email=? WHERE member_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $m_name, $gender, $phone, $email, $member_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('會員更新成功'); window.location.href='member_list.php';</script>";
    } else {
        echo "<script>alert('更新失敗: ".$stmt->error."');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='zh-TW'>
<head>
    <meta charset='UTF-8'>
    <title>編輯會員</title>
</head>
<body class='p-4'>

    <h2>編輯會員</h2>

    <form method='POST'>
        <div class='mb-3'>
            <label>姓名</label>
            <input type='text' name='m_name' class='form-control' value="<?= $member['m_name'] ?>" required>
        </div>

        <div class='mb-3'>
            <label>性別</label>
            <select name='gender' class='form-select'>
                <option value='male' <?= $member['gender']=='male'?'selected':'' ?>>男</option>
                <option value='female' <?= $member['gender']=='female'?'selected':'' ?>>女</option>
            </select>
        </div>

        <div class='mb-3'>
            <label>電話</label>
            <input type='text' name='phone' class='form-control' value="<?= $member['phone'] ?>">
        </div>

        <div class='mb-3'>
            <label>Email</label>
            <input type='email' name='email' class='form-control' value="<?= $member['email'] ?>" required>
        </div>

        <div class='mb-3'>
            <label>密碼（留空則不修改）</label>
            <input type='text' name='m_password' class='form-control'>
        </div>

        <button class='btn btn-primary'>更新會員</button>
        <a href='member_list.php' class='btn btn-secondary'>返回列表</a>
    </form>

</body>
</html>
