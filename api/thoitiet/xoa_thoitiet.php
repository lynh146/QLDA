<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTT = $_POST['MaTT'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM thoitiet t
                                 JOIN losx l ON t.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE t.MaTT=?");
        $check->execute([$maTT]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền xóa dữ liệu này";
            exit;
        }
    }

    $sql = "DELETE FROM thoitiet WHERE MaTT=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTT]);

    echo "✅ Xóa Thời tiết thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
