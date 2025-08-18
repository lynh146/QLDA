<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$maGiong    = $_POST['MaGiong'] ?? '';
$tenGiong   = $_POST['TenGiong'] ?? '';
$nguonGoc   = $_POST['NguonGoc'] ?? '';
$tgTruong   = $_POST['TGTruong'] ?? 0;
$nangSuatTB = $_POST['NangSuatTB'] ?? 0;

try {
    $sql = "UPDATE giong 
            SET TenGiong=?, NguonGoc=?, TGTruong=?, NangSuatTB=? 
            WHERE MaGiong=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tenGiong, $nguonGoc, $tgTruong, $nangSuatTB, $maGiong]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
