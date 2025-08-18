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
            echo "Bạn không có quyền xóa phân bón này";
            exit;
        }
    }

    $sql = "DELETE FROM phanbon WHERE MaPhan=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maPhan]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
