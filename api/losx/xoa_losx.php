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

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM losx l 
                                 JOIN vuon v ON l.MaVuon = v.MaVuon 
                                 WHERE l.MaLo = ?");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền xóa lô này";
            exit;
        }
    }

    $sql = "DELETE FROM losx WHERE MaLo=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
