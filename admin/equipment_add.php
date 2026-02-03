<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

$member_result = $conn->query("SELECT * FROM Member");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_name = $_POST['equipment_name'];
    $member_id = $_POST['member_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO EquipmentUsage (equipment_name, member_id, start_time, end_time)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $equipment_name, $member_id, $start_time, $end_time);

    if ($stmt->execute()) {
        echo "<script>alert('器材使用紀錄新增成功');location.href='equipment_list.php';</script>"; exit;
    } else {
        $error = "新增失敗：" . $stmt->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>新增器材使用紀錄</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">器材名稱</label>
        <input type="text" name="equipment_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">會員</label>
        <select name="member_id" class="form-select" required>
            <option value="">請選擇會員</option>
            <?php while($m = $member_result->fetch_assoc()): ?>
                <option value="<?=$m['member_id']?>"><?=htmlspecialchars($m['m_name'])?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">開始時間</label>
        <input type="datetime-local" name="start_time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">結束時間</label>
        <input type="datetime-local" name="end_time" class="form-control" required>
    </div>
    <button class="btn btn-primary">送出</button>
    <a href="equipment_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
