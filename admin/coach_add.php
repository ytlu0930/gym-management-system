<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c_name = $_POST['c_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password_plain = $_POST['c_password'];
    $c_password = password_hash($password_plain, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Coach (c_name, gender, phone, email, c_password)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $c_name, $gender, $phone, $email, $c_password);

    if ($stmt->execute()) {
        echo "<script>alert('教練新增成功'); location.href='coach_list.php';</script>"; exit;
    } else {
        $error = "新增失敗：" . $stmt->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>新增教練</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">姓名</label>
        <input type="text" name="c_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">性別</label>
        <select name="gender" class="form-select">
            <option value="male">男</option>
            <option value="female">女</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">電話</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">密碼</label>
        <input type="password" name="c_password" class="form-control" required>
    </div>
    <button class="btn btn-primary">送出</button>
    <a href="coach_list.php" class="btn btn-secondary">返回</a>
</form>

<?php include "template/footer.php"; ?>
