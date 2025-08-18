<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

try {
    if ($role === 'admin') {
        $sql = "SELECT l.*, n.TenND 
                FROM losx l 
                JOIN vuon v ON l.MaVuon = v.MaVuon
                JOIN nongdan n ON v.MaND = n.MaND";
        $stmt = $conn->query($sql);
    } else {
        $sql = "SELECT l.* 
                FROM losx l 
                JOIN vuon v ON l.MaVuon = v.MaVuon
                WHERE v.MaND = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$maND]);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
