<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "❌ Chưa đăng nhập"]);
    exit;
}

$role = $_SESSION['role'];
$isAdmin = ($role === 'admin');

try {
    $sql = "SELECT MaGiong, TenGiong, NguonGoc, TGTruong, NangSuatTB FROM giong";
    $rows = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "IsAdmin" => $isAdmin,
        "Data" => $rows
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
