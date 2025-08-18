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
            echo "Bạn không có quyền xóa bản ghi này";
            exit;
        }
    }

    $sql = "DELETE FROM thuhoach WHERE MaTH=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTH]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
