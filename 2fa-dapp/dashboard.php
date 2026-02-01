<?php
include "db.php";
if (!isset($_SESSION['login_ok']) || $_SESSION['login_ok'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - 2FA DApp</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
            <h1>Bảo mật Thành công!</h1>
            <p class="subtitle">Bạn đã đăng nhập an toàn bằng 2 lớp bảo mật.</p>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 1rem; color: #818cf8;">Thông tin phiên đăng nhập</h3>
            <p style="margin-bottom: 0.5rem;">Username: <strong><?php echo $_SESSION['username']; ?></strong></p>
            <p style="margin-bottom: 0.5rem; word-break: break-all;">Ví xác thực: <code><?php echo $_SESSION['wallet']; ?></code></p>
            <p style="color: #4ade80; font-size: 0.9rem;">● Trạng thái: Đã xác thực (Verified)</p>
        </div>

        <div style="margin-top: 2rem;">
            <button class="btn-secondary" onclick="location.href='logout.php'">Đăng xuất</button>
        </div>
    </div>
</body>
</html>
