<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['role'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

$maVuon = $_GET['MaVuon'] ?? null;
if (!$maVuon) {
    echo json_encode(["error" => "Thiếu mã vườn"]);
    exit;
}

if ($_SESSION['role'] === 'nongdan') {
    // Nông dân chỉ được xóa vườn của mình
    $maND = $_SESSION['id'];
    $sql = "DELETE FROM vuon WHERE MaVuon=? AND MaND=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $maND]);

} elseif ($_SESSION['role'] === 'admin') {
    // Admin được phép xóa bất kỳ
    $sql = "DELETE FROM vuon WHERE MaVuon=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon]);
}

echo json_encode(["success" => true]);
