<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLich = $_POST['MaLich'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM lich l
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE l.MaLich=?");
        $check->execute([$maLich]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền xóa lịch này";
            exit;
        }
    }

    $sql = "DELETE FROM lich WHERE MaLich=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLich]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
