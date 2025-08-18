<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$tenVuon   = $_POST['TenVuon'] ?? '';
$dienTich  = $_POST['DienTich'] ?? 0;
$loaiDat   = $_POST['LoaiDat'] ?? '';
$viTri     = $_POST['ViTri'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';

// Nếu admin → cho phép chọn MaND
if ($role === 'admin') {
    $maND = $_POST['MaND'] ?? null;
    if (!$maND) {
        echo "❌ Thiếu mã nông dân";
        exit;
    }
}

// Sinh mã vườn mới (V001, V002…)
$sqlMax = "SELECT MaVuon FROM vuon ORDER BY MaVuon DESC LIMIT 1";
$res = $conn->query($sqlMax);
$last = $res->fetchColumn();

if ($last) {
    $num = (int)substr($last, 1) + 1; // bỏ chữ V
} else {
    $num = 1;
}
$maVuon = "V" . str_pad($num, 3, "0", STR_PAD_LEFT);

try {
    $sql = "INSERT INTO vuon (MaVuon, TenVuon, DienTich, LoaiDat, ViTri, TrangThai, MaND) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $tenVuon, $dienTich, $loaiDat, $viTri, $trangThai, $maND]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
