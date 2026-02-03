<?php
require_once "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $m_name = $_POST['m_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $m_password = $_POST['m_password'];   // ⭐ 明文密碼

    $sql = "INSERT INTO Member (m_name, gender, phone, email, m_password) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $m_name, $gender, $phone, $email, $m_password);

    if ($stmt->execute()) {
        echo "<script>alert('會員新增成功'); window.location.href='member_list.php';</script>";
    } else {
        echo "<script>alert('新增失敗: ".$stmt->error."');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='zh-TW'>
<head>
    <meta charset='UTF-8'>
    <title>新增會員</title>
    <link rel='stylesheet' href='assets/css/bootstrap.min.css'>
</head>
<body class='p-4'>
    <h2>新增會員</h2>

    <form method='POST'>
        <div class='mb-3'>
            <label>姓名</label>
            <input type='text' name='m_name' class='form-control' required>
        </div>

        <div class='mb-3'>
            <label>性別</label>
            <select name='gender' class='form-select'>
                <option value='male'>男</option>
                <option value='female'>女</option>
            </select>
        </div>

        <div class='mb-3'>
            <label>電話</label>
            <input type='text' name='phone' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>Email</label>
            <input type='email' name='email' class='form-control' required>
        </div>

        <div class='mb-3'>
            <label>密碼（明文）</label>
            <input type='text' name='m_password' class='form-control' required>
        </div>

        <button class='btn btn-primary'>新增會員</button>
        <a href='member_list.php' class='btn btn-secondary'>返回列表</a>
    </form>
</body>
</html>
