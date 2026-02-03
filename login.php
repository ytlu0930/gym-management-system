<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>登入 - 健身房管理系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #111;
            color: #fff;
        }
        .card {
            background-color: #000;
            border: 2px solid gold;
            color: white;
        }
        label {
            color: #fff;
        }
        input {
            background: #222 !important;
            color: #fff !important;
            border: 1px solid #555 !important;
        }
        input::placeholder {
            color: #bbb;
        }
        .btn-gold {
            background-color: gold;
            color: black;
            font-weight: bold;
        }
        .btn-gold:hover {
            background-color: #e0b800;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center" style="min-height:100vh;">

    <div class="card p-4" style="max-width:400px; width:100%;">
        <h3 class="mb-3 text-center" style="color:gold;">健身房管理系統</h3>

        <?php if(isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <form action="login_check.php" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="請輸入 Email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">密碼</label>
                <input type="password" name="password" class="form-control" placeholder="請輸入密碼" required>
            </div>

            <button class="btn btn-gold w-100">登入</button>
        </form>
    </div>

</body>
</html>
