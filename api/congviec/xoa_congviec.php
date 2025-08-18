<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maCV = $_POST['MaCV'] ?? '';

try {
    if ($role !== 'admin') {
        // Kiểm tra công việc có thuộc Nông dân này không
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM congviec c
                                 JOIN losx l ON c.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE c.MaCV = ?");
        $check->execute([$maCV]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền xóa công việc này";
            exit;
        }
    }

    $sql = "DELETE FROM congviec WHERE MaCV=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maCV]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
