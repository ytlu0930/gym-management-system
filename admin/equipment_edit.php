<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

if (!isset($_GET['usage_id'])) {
    header("Location: equipment_list.php"); exit;
}
$usage_id = (int)$_GET['usage_id'];

$stmt = $conn->prepare("SELECT * FROM EquipmentUsage WHERE usage_id=?");
$stmt->bind_param("i", $usage_id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();
if (!$record) {
    echo "<script>alert('找不到紀錄');location.href='equipment_list.php';</script>"; exit;
}

$member_result = $conn->query("SELECT * FROM Member");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_name = $_POST['equipment_name'];
    $member_id = $_POST['member_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "UPDATE EquipmentUsage SET equipment_name=?, member_id=?, start_time=?, end_time=? WHERE usage_id=?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("sissi", $equipment_name, $member_id, $start_time, $end_time, $usage_id);

    if ($stmt2->execute()) {
        echo "<script>alert('紀錄更新成功');location.href='equipment_list.php';</script>"; exit;
    } else {
        $error = "更新失敗：" . $stmt2->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>編輯器材使用紀錄</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">器材名稱</label>
        <input type="text" name="equipment_name" class="form-control"
               value="<?=htmlspecialchars($record['equipment_name'])?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">會員</label>
        <select name="member_id" class="form-select" required>
            <?php while($m = $member_result->fetch_assoc()): ?>
                <option value="<?=$m['member_id']?>"
                    <?=$m['member_id']==$record['member_id']?'selected':''?>>
                    <?=htmlspecialchars($m['m_name'])?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">開始時間</label>
        <input type="datetime-local" name="start_time" class="form-control"
               value="<?= date('Y-m-d\TH:i', strtotime($record['start_time'])) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">結束時間</label>
        <input type="datetime-local" name="end_time" class="form-control"
               value="<?= date('Y-m-d\TH:i', strtotime($record['end_time'])) ?>" required>
    </div>
    <button class="btn btn-primary">更新</button>
    <a href="equipment_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
