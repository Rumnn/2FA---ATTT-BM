<?php
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Tạo Nonce ngẫu nhiên nếu chưa có để bảo mật
if (!isset($_SESSION['nonce'])) {
    $_SESSION['nonce'] = bin2hex(random_bytes(16));
}
$nonce = $_SESSION['nonce'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực 2FA - 2FA DApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="text-align: center;">
        <h1>Xác thực 2FA</h1>
        <p class="subtitle">Bước 2: Ký xác thực bằng MetaMask</p>
        
        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem;">
            <p style="font-size: 0.9rem; color: var(--text-muted);">Tài khoản: <strong><?php echo $_SESSION['username']; ?></strong></p>
            <p style="font-size: 0.8rem; color: var(--text-muted); word-break: break-all;">Ví yêu cầu: <br><code><?php echo $_SESSION['wallet']; ?></code></p>
        </div>

        <button onclick="verify()">Ký xác thực ngay</button>
        
        <div id="status" style="margin-top: 1.5rem; display: none;" class="status-msg"></div>

        <div class="footer-link">
            <a href="logout.php">Hủy đăng nhập</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.umd.min.js"></script>
    <script>
    async function verify() {
        const btn = document.querySelector('button');
        const statusDiv = document.getElementById('status');
        
        if (!window.ethereum) {
            alert("Vui lòng cài MetaMask!");
            return;
        }

        try {
            btn.disabled = true;
            btn.innerText = "Đang xử lý...";
            
            const provider = new ethers.providers.Web3Provider(window.ethereum);
            await provider.send("eth_requestAccounts", []);
            const signer = provider.getSigner();

            // Lấy nonce từ PHP session đã render ra
            const nonce = "<?php echo $nonce; ?>";
            const message = "Xác nhận đăng nhập vào 2FA DApp System\nNonce: " + nonce + "\nTimestamp: " + new Date().getTime();
            const signature = await signer.signMessage(message);
            const address = await signer.getAddress();

            const response = await fetch("verify_server.php", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    address: address,
                    signature: signature,
                    message: message
                })
            });

            const result = await response.json();
            
            if (result.status === "OK") {
                statusDiv.style.display = "block";
                statusDiv.className = "status-msg status-success";
                statusDiv.innerText = "Xác thực thành công! Đang chuyển hướng...";
                setTimeout(() => location.href = "dashboard.php", 1500);
            } else {
                statusDiv.style.display = "block";
                statusDiv.className = "status-msg status-error";
                statusDiv.innerText = result.message || "Xác thực thất bại";
                btn.disabled = false;
                btn.innerText = "Ký xác thực ngay";
            }
        } catch (err) {
            console.error(err);
            alert("Lỗi: " + err.message);
            btn.disabled = false;
            btn.innerText = "Ký xác thực ngay";
        }
    }
    </script>
</body>
</html>
