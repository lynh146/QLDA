<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTB = $_POST['MaTB'] ?? '';
$maVuon = $_POST['MaVuon'] ?? '';
$tenTB = $_POST['TenTB'] ?? '';
$loaiTB = $_POST['LoaiTB'] ?? '';
$ngayCaiDat = $_POST['NgayCaiDat'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM thietbi t
                                 JOIN vuon v ON t.MaVuon = v.MaVuon
                                 WHERE t.MaTB=?");
        $check->execute([$maTB]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa thiết bị này";
            exit;
        }
    }

    $sql = "UPDATE thietbi
            SET MaVuon=?, TenTB=?, LoaiTB=?, NgayCaiDat=?, TrangThai=?
            WHERE MaTB=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $tenTB, $loaiTB, $ngayCaiDat, $trangThai, $maTB]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
