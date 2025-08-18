<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maBC     = $_POST['MaBC'] ?? '';
$loaiBC   = $_POST['LoaiBC'] ?? '';
$thoiGian = $_POST['ThoiGian'] ?? '';
$noiDung  = $_POST['NoiDung'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM baocao b
                                 JOIN vuon v ON b.MaVuon = v.MaVuon
                                 WHERE b.MaBC=?");
        $check->execute([$maBC]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa báo cáo này";
            exit;
        }
    }

    $sql = "UPDATE baocao SET LoaiBC=?, ThoiGian=?, NoiDung=? WHERE MaBC=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$loaiBC, $thoiGian, $noiDung, $maBC]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
