<?php
include "db.php";
$msg = "";
$status = "";

if ($_POST) {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $wallet = $_POST['wallet'];

    $stmt = $conn->prepare("INSERT INTO users(username, password, wallet_address) VALUES(?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $wallet);
    
    if ($stmt->execute()) {
        $msg = "Đăng ký thành công! <a href='login.php' style='color:inherit;text-decoration:underline;'>Đăng nhập ngay</a>";
        $status = "success";
    } else {
        $msg = "Username đã tồn tại hoặc lỗi CSDL";
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - 2FA DApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tạo tài khoản</h1>
        <p class="subtitle">Bảo mật 2 lớp với MetaMask</p>

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
            <div class="form-group">
                <label>Wallet Address (MetaMask)</label>
                <input type="text" id="wallet" name="wallet" required placeholder="0x...">
                <button type="button" class="btn-secondary" onclick="connectWallet()" style="font-size: 0.8rem; padding: 0.5rem; margin-top: 0.5rem;">
                    🔗 Kết nối MetaMask
                </button>
            </div>
            <button type="submit">Đăng ký</button>
        </form>

        <div class="footer-link">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </div>
    </div>

    <script>
    async function connectWallet() {
        if (window.ethereum) {
            try {
                const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                document.getElementById('wallet').value = accounts[0];
            } catch (err) {
                alert("Bạn đã từ chối kết nối!");
            }
        } else {
            alert("Vui lòng cài đặt MetaMask extension!");
        }
    }
    </script>
</body>
</html>
