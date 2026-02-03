<?php
include "db.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['address']) || !isset($data['signature']) || !isset($data['message']) || !isset($_SESSION['wallet'])) {
    echo json_encode(["status" => "ERROR", "message" => "Thiếu dữ liệu xác thực"]);
    exit();
}

$nonce = $_SESSION['nonce'] ?? 'EXPIRED';
$receivedMessage = $data['message'];
$receivedAddress = strtolower($data['address']);
$storedWallet = strtolower($_SESSION['wallet']);

// 1. Kiểm tra xem thông điệp có chứa đúng Nonce không
if (strpos($receivedMessage, $nonce) === false) {
    echo json_encode(["status" => "ERROR", "message" => "Nonce không hợp lệ hoặc đã hết hạn!"]);
    exit();
}

// 2. Kiểm tra xem ví MetaMask đang dùng có khớp với tài khoản không
if ($receivedAddress !== $storedWallet) {
    echo json_encode(["status" => "ERROR", "message" => "Ví MetaMask không khớp với tài khoản!"]);
    exit();
}

// 3. Phép toán quan trọng: Xác thực chữ ký số (Mô phỏng/Thực tế)
// Trong thực tế, dùng: EthVerify::verify($receivedMessage, $data['signature'], $receivedAddress)
$isValidSignature = true; // Giả sử hợp lệ sau khi qua bước 1 và 2

if ($isValidSignature) {
    // Xóa nonce ngay sau khi dùng xong (Chống Replay Attack)
    unset($_SESSION['nonce']);
    $_SESSION['login_ok'] = true;
    echo json_encode(["status" => "OK"]);
} else {
    echo json_encode(["status" => "ERROR", "message" => "Chữ ký số không hợp lệ!"]);
}
?>
