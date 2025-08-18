<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLo = $_POST['MaLo'] ?? '';
$maVuon = $_POST['MaVuon'] ?? '';
$maGiong = $_POST['MaGiong'] ?? '';
$dienTich = $_POST['DienTich'] ?? 0;
$ngayBD = $_POST['NgayBD'] ?? '';
$ngayKT = $_POST['NgayKT'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM losx l 
                                 JOIN vuon v ON l.MaVuon = v.MaVuon 
                                 WHERE l.MaLo = ?");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa lô này";
            exit;
        }
    }

    $sql = "UPDATE losx 
            SET MaVuon=?, MaGiong=?, DienTich=?, NgayBD=?, NgayKT=? 
            WHERE MaLo=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $maGiong, $dienTich, $ngayBD, $ngayKT, $maLo]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
