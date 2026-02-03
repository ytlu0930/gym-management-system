<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

if (!isset($_GET['attendance_id'])) {
    header("Location: attendance_list.php"); exit;
}
$attendance_id = (int)$_GET['attendance_id'];

$stmt = $conn->prepare("SELECT * FROM Attendance WHERE attendance_id=?");
$stmt->bind_param("i", $attendance_id);
$stmt->execute();
$attendance = $stmt->get_result()->fetch_assoc();
if (!$attendance) {
    echo "<script>alert('找不到資料');location.href='attendance_list.php';</script>"; exit;
}

$member_result = $conn->query("SELECT * FROM Member");
$course_result = $conn->query("SELECT * FROM Course");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $course_id = $_POST['course_id'];
    $attendance_time = $_POST['attendance_time'];

    $sql = "UPDATE Attendance SET member_id=?, course_id=?, attendance_time=? WHERE attendance_id=?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("iisi", $member_id, $course_id, $attendance_time, $attendance_id);

    if ($stmt2->execute()) {
        echo "<script>alert('簽到紀錄更新成功');location.href='attendance_list.php';</script>"; exit;
    } else {
        $error = "更新失敗：" . $stmt2->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>編輯簽到紀錄</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">會員</label>
        <select name="member_id" class="form-select" required>
            <?php while($m = $member_result->fetch_assoc()): ?>
                <option value="<?=$m['member_id']?>"
                    <?=$m['member_id']==$attendance['member_id']?'selected':''?>>
                    <?=htmlspecialchars($m['m_name'])?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">課程</label>
        <select name="course_id" class="form-select" required>
            <?php while($c = $course_result->fetch_assoc()): ?>
                <option value="<?=$c['course_id']?>"
                    <?=$c['course_id']==$attendance['course_id']?'selected':''?>>
                    <?=htmlspecialchars($c['course_name'])?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">簽到時間</label>
        <input type="datetime-local" name="attendance_time" class="form-control"
               value="<?= date('Y-m-d\TH:i', strtotime($attendance['attendance_time'])) ?>" required>
    </div>
    <button class="btn btn-primary">更新</button>
    <a href="attendance_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
