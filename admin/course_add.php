<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

$coach_result = $conn->query("SELECT * FROM Coach");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $coach_id = $_POST['coach_id'];
    $course_date = $_POST['course_date'];
    $course_time = $_POST['course_time'];
    $location = $_POST['location'];

    $sql = "INSERT INTO Course (course_name, coach_id, course_date, course_time, location)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $course_name, $coach_id, $course_date, $course_time, $location);

    if ($stmt->execute()) {
        echo "<script>alert('課程新增成功');location.href='course_list.php';</script>"; exit;
    } else {
        $error = "新增失敗：" . $stmt->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>新增課程</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">課程名稱</label>
        <input type="text" name="course_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">授課教練</label>
        <select name="coach_id" class="form-select" required>
            <option value="">請選擇教練</option>
            <?php while($coach = $coach_result->fetch_assoc()): ?>
                <option value="<?=$coach['coach_id']?>"><?=htmlspecialchars($coach['c_name'])?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">上課日期</label>
        <input type="date" name="course_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">上課時間</label>
        <input type="time" name="course_time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">地點</label>
        <input type="text" name="location" class="form-control">
    </div>
    <button class="btn btn-primary">送出</button>
    <a href="course_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
