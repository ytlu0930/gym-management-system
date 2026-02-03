<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit;
}
require_once "../connect.php";
include "template/header.php";
include "template/sidebar.php";
?>

<h2>🏋️‍♂️ 管理後台主面板</h2>
<p>歡迎管理員： <b style="color:gold;"><?= htmlspecialchars($_SESSION['admin_name']) ?></b></p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-bg-dark mb-3" style="border:1px solid gold;">
            <div class="card-body">
                <h5 class="card-title">會員數</h5>
                <p class="card-text">
                    <?php
                    $c = $conn->query("SELECT COUNT(*) AS cnt FROM Member")->fetch_assoc();
                    echo $c['cnt'];
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-dark mb-3" style="border:1px solid gold;">
            <div class="card-body">
                <h5 class="card-title">教練數</h5>
                <p class="card-text">
                    <?php
                    $c = $conn->query("SELECT COUNT(*) AS cnt FROM Coach")->fetch_assoc();
                    echo $c['cnt'];
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-dark mb-3" style="border:1px solid gold;">
            <div class="card-body">
                <h5 class="card-title">課程數</h5>
                <p class="card-text">
                    <?php
                    $c = $conn->query("SELECT COUNT(*) AS cnt FROM Course")->fetch_assoc();
                    echo $c['cnt'];
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
