<?php
include "db.php";
$msg = "";
$status = "";

if ($_POST) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['wallet'] = $row['wallet_address'];
        header("Location: verify_signature.php");
        exit();
    } else {
        $msg = "Sai Username hoặc Password";
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - 2FA DApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Đăng nhập</h1>
        <p class="subtitle">Bước 1: Xác thực mật khẩu</p>

        <?php if ($msg): ?>
            <div class="status-msg status-<?php echo $status; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Nhập tên đăng nhập">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Nhập mật khẩu">
            </div>
            <button type="submit">Tiếp tục</button>
        </form>

        <div class="footer-link">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html>
