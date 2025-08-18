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
            echo "Bạn không có quyền xóa nhật ký này";
            exit;
        }
    }

    $sql = "DELETE FROM nhatky WHERE MaNK=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maNK]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
