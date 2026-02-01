<?php
include "db.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['address']) || !isset($_SESSION['wallet'])) {
    echo json_encode(["status" => "ERROR", "message" => "Thiếu dữ liệu"]);
    exit();
}

$receivedAddress = strtolower($data['address']);
$storedWallet = strtolower($_SESSION['wallet']);

if ($receivedAddress === $storedWallet) {
    $_SESSION['login_ok'] = true;
    echo json_encode(["status" => "OK"]);
} else {
    echo json_encode(["status" => "ERROR", "message" => "Ví MetaMask không khớp với tài khoản!"]);
}
?>
