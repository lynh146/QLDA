<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maThuoc = $_POST['MaThuoc'] ?? '';
$maLo = $_POST['MaLo'] ?? '';
$tenThuoc = $_POST['TenThuoc'] ?? '';
$soLuong = $_POST['SoLuong'] ?? 0;
$donVi = $_POST['DonVi'] ?? '';
$ngaySD = $_POST['NgaySD'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM thuoc t
                                 JOIN losx l ON t.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE t.MaThuoc = ?");
        $check->execute([$maThuoc]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa thuốc này";
            exit;
        }
    }

    $sql = "UPDATE thuoc
            SET MaLo=?, TenThuoc=?, SoLuong=?, DonVi=?, NgaySD=?
            WHERE MaThuoc=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $tenThuoc, $soLuong, $donVi, $ngaySD, $maThuoc]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
