<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

try {
    // Chỉ lấy thông tin cần thiết, KHÔNG lấy mật khẩu
    $sql = "SELECT MaND, TenND, CCCD, DiaChi, SDT, Email, Username 
            FROM nongdan";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
