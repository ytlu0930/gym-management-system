<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";

if (!isset($_GET['course_id'])) {
    header("Location: course_list.php"); exit;
}
$course_id = (int)$_GET['course_id'];

$stmt = $conn->prepare("SELECT * FROM Course WHERE course_id=?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

if (!$course) {
    echo "<script>alert('找不到課程');location.href='course_list.php';</script>"; exit;
}

$coach_result = $conn->query("SELECT * FROM Coach");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $coach_id = $_POST['coach_id'];
    $course_date = $_POST['course_date'];
    $course_time = $_POST['course_time'];
    $location = $_POST['location'];

    $sql = "UPDATE Course SET course_name=?, coach_id=?, course_date=?, course_time=?, location=? WHERE course_id=?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("sisssi", $course_name, $coach_id, $course_date, $course_time, $location, $course_id);

    if ($stmt2->execute()) {
        echo "<script>alert('課程更新成功');location.href='course_list.php';</script>"; exit;
    } else {
        $error = "更新失敗：" . $stmt2->error;
    }
}

include "template/header.php";
include "template/sidebar.php";
?>
<h2>編輯課程</h2>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">課程名稱</label>
        <input type="text" name="course_name" class="form-control"
               value="<?=htmlspecialchars($course['course_name'])?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">授課教練</label>
        <select name="coach_id" class="form-select" required>
            <option value="">請選擇教練</option>
            <?php while($coach = $coach_result->fetch_assoc()): ?>
                <option value="<?=$coach['coach_id']?>"
                    <?=$coach['coach_id']==$course['coach_id']?'selected':''?>>
                    <?=htmlspecialchars($coach['c_name'])?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">上課日期</label>
        <input type="date" name="course_date" class="form-control"
               value="<?=$course['course_date']?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">上課時間</label>
        <input type="time" name="course_time" class="form-control"
               value="<?=$course['course_time']?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">地點</label>
        <input type="text" name="location" class="form-control"
               value="<?=htmlspecialchars($course['location'])?>">
    </div>
    <button class="btn btn-primary">更新</button>
    <a href="course_list.php" class="btn btn-secondary">返回</a>
</form>
<?php include "template/footer.php"; ?>
