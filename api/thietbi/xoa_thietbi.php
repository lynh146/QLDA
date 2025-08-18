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

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM thietbi t
                                 JOIN vuon v ON t.MaVuon = v.MaVuon
                                 WHERE t.MaTB=?");
        $check->execute([$maTB]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền xóa thiết bị này";
            exit;
        }
    }

    $sql = "DELETE FROM thietbi WHERE MaTB=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTB]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
