<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLich   = $_POST['MaLich'] ?? '';
$maVuon   = $_POST['MaVuon'] ?? '';
$thoiGian = $_POST['ThoiGian'] ?? '';
$congViec = $_POST['CongViec'] ?? '';
$trangThai= $_POST['TrangThai'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM lich l
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE l.MaLich=?");
        $check->execute([$maLich]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa lịch này";
            exit;
        }
    }

    $sql = "UPDATE lich SET MaVuon=?, ThoiGian=?, CongViec=?, TrangThai=? WHERE MaLich=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $thoiGian, $congViec, $trangThai, $maLich]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
