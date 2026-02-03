<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

$member_result = $conn->query("SELECT * FROM Member");
$course_result = $conn->query("SELECT * FROM Course");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $course_id = $_POST['course_id'];
    $attendance_time = $_POST['attendance_time'];

    $sql = "INSERT INTO Attendance (member_id, course_id, attendance_time)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $member_id, $course_id, $attendance_time);

    if ($stmt->execute()) {
        echo "<script>alert('簽到紀錄新增成功');location.href='attendance_list.php';</script>"; exit;
    } else {
        $error = "新增失敗：" . $stmt->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>新增簽到紀錄</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
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
        <label class="form-label">課程</label>
        <select name="course_id" class="form-select" required>
            <option value="">請選擇課程</option>
            <?php while($c = $course_result->fetch_assoc()): ?>
                <option value="<?=$c['course_id']?>"><?=htmlspecialchars($c['course_name'])?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">簽到時間</label>
        <input type="datetime-local" name="attendance_time" class="form-control" required>
    </div>
    <button class="btn btn-primary">送出</button>
    <a href="attendance_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
