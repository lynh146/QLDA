<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$maGiong = $_POST['MaGiong'] ?? '';

try {
    $sql = "DELETE FROM giong WHERE MaGiong=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maGiong]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
