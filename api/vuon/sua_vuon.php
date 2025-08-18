<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['role'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

$maVuon = $_POST['MaVuon'] ?? null;
$tenVuon = $_POST['TenVuon'] ?? '';
$dienTich = $_POST['DienTich'] ?? 0;
$loaiDat = $_POST['LoaiDat'] ?? '';
$viTri = $_POST['ViTri'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';
$maND = null;

if (!$maVuon) {
    echo json_encode(["error" => "Thiếu mã vườn"]);
    exit;
}

// Nếu nông dân → chỉ được sửa vườn của chính mình
if ($_SESSION['role'] === 'nongdan') {
    $maND = $_SESSION['id'];
    $sql = "UPDATE vuon SET TenVuon=?, DienTich=?, LoaiDat=?, ViTri=?, TrangThai=? 
            WHERE MaVuon=? AND MaND=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tenVuon, $dienTich, $loaiDat, $viTri, $trangThai, $maVuon, $maND]);

} elseif ($_SESSION['role'] === 'admin') {
    // Admin có thể cập nhật cả MaND
    $maND = $_POST['MaND'] ?? null;
    $sql = "UPDATE vuon SET TenVuon=?, DienTich=?, LoaiDat=?, ViTri=?, TrangThai=?, MaND=? 
            WHERE MaVuon=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tenVuon, $dienTich, $loaiDat, $viTri, $trangThai, $maND, $maVuon]);
}

echo json_encode(["success" => true]);
