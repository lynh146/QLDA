<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maPhan = $_POST['MaPhan'] ?? '';
$maLo = $_POST['MaLo'] ?? '';
$tenPhan = $_POST['TenPhan'] ?? '';
$soLuong = $_POST['SoLuong'] ?? 0;
$donVi = $_POST['DonVi'] ?? '';
$ngaySD = $_POST['NgaySD'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM phanbon p
                                 JOIN losx l ON p.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE p.MaPhan = ?");
        $check->execute([$maPhan]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa phân bón này";
            exit;
        }
    }

    $sql = "UPDATE phanbon 
            SET MaLo=?, TenPhan=?, SoLuong=?, DonVi=?, NgaySD=? 
            WHERE MaPhan=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $tenPhan, $soLuong, $donVi, $ngaySD, $maPhan]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
