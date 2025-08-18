<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "SELECT MaGiong, TenGiong, NguonGoc, TGTruong, NangSuatTB FROM giong";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows, JSON_UNESCAPED_UNICODE); 
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
