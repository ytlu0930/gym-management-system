<?php
require_once "../connect.php";

if (!isset($_GET['coach_id'])) {
    header("Location: coach_list.php");
    exit;
}

$coach_id = $_GET['coach_id'];

$stmt = $conn->prepare("SELECT * FROM Coach WHERE coach_id=?");
$stmt->bind_param("i", $coach_id);
$stmt->execute();
$res = $stmt->get_result();
$coach = $res->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c_name = $_POST['c_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password_input = $_POST['c_password'];

    if (!empty($password_input)) {
        $sql = "UPDATE Coach SET c_name=?, gender=?, phone=?, email=?, c_password=? WHERE coach_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $c_name, $gender, $phone, $email, $password_input, $coach_id);
    } else {
        $sql = "UPDATE Coach SET c_name=?, gender=?, phone=?, email=? WHERE coach_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $c_name, $gender, $phone, $email, $coach_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('教練資料更新成功'); window.location.href='coach_list.php';</script>";
    } else {
        echo "<script>alert('更新失敗: ".$stmt->error."');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='zh-TW'>
<head>
    <meta charset='UTF-8'>
    <title>編輯教練</title>
</head>
<body class='p-4'>
    <h2>編輯教練</h2>

    <form method='POST'>
        <div class='mb-3'>
            <label>姓名</label>
            <input type='text' name='c_name' class='form-control' value="<?= $coach['c_name'] ?>" required>
        </div>

        <div class='mb-3'>
            <label>性別</label>
            <select name='gender' class='form-select'>
                <option value='male' <?= $coach['gender']=='male'?'selected':'' ?>>男</option>
                <option value='female' <?= $coach['gender']=='female'?'selected':'' ?>>女</option>
            </select>
        </div>

        <div class='mb-3'>
            <label>電話</label>
            <input type='text' name='phone' class='form-control' value="<?= $coach['phone'] ?>">
        </div>

        <div class='mb-3'>
            <label>Email</label>
            <input type='email' name='email' class='form-control' value="<?= $coach['email'] ?>" required>
        </div>

        <div class='mb-3'>
            <label>密碼（留空則不修改）</label>
            <input type='text' name='c_password' class='form-control'>
        </div>

        <button class='btn btn-primary'>更新教練</button>
        <a href='coach_list.php' class='btn btn-secondary'>返回教練列表</a>
    </form>

</body>
</html>
