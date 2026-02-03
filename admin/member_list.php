<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php"); exit;
}
require_once "../connect.php";
include "template/header.php";
include "template/sidebar.php";

$result = $conn->query("SELECT * FROM Member");
?>
<h2>會員列表</h2>
<a href="member_add.php" class="btn btn-success mb-3">新增會員</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>編號</th>
            <th>姓名</th>
            <th>性別</th>
            <th>電話</th>
            <th>Email</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($m = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $m['member_id'] ?></td>
            <td><?= htmlspecialchars($m['m_name']) ?></td>
            <td><?= htmlspecialchars($m['gender']) ?></td>
            <td><?= htmlspecialchars($m['phone']) ?></td>
            <td><?= htmlspecialchars($m['email']) ?></td>
            <td>
                <a href="member_edit.php?member_id=<?=$m['member_id']?>" class="btn btn-primary btn-sm">編輯</a>
                <a href="member_delete.php?member_id=<?=$m['member_id']?>"
                   onclick="return confirm('確定要刪除嗎？');"
                   class="btn btn-danger btn-sm">刪除</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include "template/footer.php"; ?>
