<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTH = $_POST['MaTH'] ?? '';
$maLo = $_POST['MaLo'] ?? '';
$ngayTH = $_POST['NgayTH'] ?? '';
$sanLuong = $_POST['SanLuong'] ?? 0;
$chatLuong = $_POST['ChatLuong'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM thuhoach t
                                 JOIN losx l ON t.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE t.MaTH = ?");
        $check->execute([$maTH]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa bản ghi này";
            exit;
        }
    }

    $sql = "UPDATE thuhoach 
            SET MaLo=?, NgayTH=?, SanLuong=?, ChatLuong=? 
            WHERE MaTH=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $ngayTH, $sanLuong, $chatLuong, $maTH]);

    echo "✅ Sửa thành công";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
