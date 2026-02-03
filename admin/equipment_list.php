<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";
include "template/header.php";
include "template/sidebar.php";

$sql = "SELECT E.*, M.m_name 
        FROM EquipmentUsage E
        JOIN Member M ON E.member_id = M.member_id
        ORDER BY E.start_time DESC";
$result = $conn->query($sql);
?>
<h2>器材使用列表</h2>
<a href="equipment_add.php" class="btn btn-success mb-3">新增器材使用紀錄</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>編號</th>
            <th>器材名稱</th>
            <th>會員</th>
            <th>開始時間</th>
            <th>結束時間</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['usage_id'] ?></td>
            <td><?= htmlspecialchars($row['equipment_name']) ?></td>
            <td><?= htmlspecialchars($row['m_name']) ?></td>
            <td><?= $row['start_time'] ?></td>
            <td><?= $row['end_time'] ?></td>
            <td>
                <a href="equipment_edit.php?usage_id=<?=$row['usage_id']?>" class="btn btn-primary btn-sm">編輯</a>
                <a href="equipment_delete.php?usage_id=<?=$row['usage_id']?>"
                   onclick="return confirm('確定要刪除這筆紀錄嗎？');"
                   class="btn btn-danger btn-sm">刪除</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include "template/footer.php"; ?>
