<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maNK = $_POST['MaNK'] ?? '';
$maLo = $_POST['MaLo'] ?? '';
$ngayGhi = $_POST['NgayGhi'] ?? '';
$noiDung = $_POST['NoiDung'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM nhatky nk
                                 JOIN losx l ON nk.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE nk.MaNK = ?");
        $check->execute([$maNK]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa nhật ký này";
            exit;
        }
    }

    $sql = "UPDATE nhatky 
            SET MaLo=?, NgayGhi=?, NoiDung=?, TrangThai=? 
            WHERE MaNK=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $ngayGhi, $noiDung, $trangThai, $maNK]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
