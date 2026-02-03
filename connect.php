<?php
$host = "localhost";
$user = "root";   // XAMPP 預設帳號
$pass = "";       // XAMPP 預設密碼（空）
$dbname = "gym_management";  // 剛剛建立的資料庫名稱

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
