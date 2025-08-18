<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTX = $_POST['MaTX'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM truyxuat t
                                 JOIN thuhoach h ON t.MaTH = h.MaTH
                                 JOIN losx l ON h.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE t.MaTX=?");
        $check->execute([$maTX]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền xóa truy xuất này";
            exit;
        }
    }

    $sql = "DELETE FROM truyxuat WHERE MaTX=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTX]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
