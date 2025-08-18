<?php
session_start();
require __DIR__ . '/../../config/connect.php';

header("Content-Type: application/json");

$role = $_SESSION['role'] ?? '';
$id   = $_SESSION['id'] ?? '';

try {
    if ($role === 'admin') {
        $sql = "SELECT v.MaVuon, v.TenVuon, v.DienTich, v.LoaiDat, v.ViTri, v.TrangThai,
               IFNULL(n.TenND, 'Chưa gán') AS TenND, n.MaND
        FROM vuon v
        LEFT JOIN nongdan n ON v.MaND = n.MaND";

        $stmt = $conn->query($sql);
    } elseif ($role === 'nongdan') {
        $sql = "SELECT MaVuon, TenVuon, DienTich, LoaiDat, ViTri, TrangThai
                FROM vuon WHERE MaND = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    } else {
        echo json_encode([]);
        exit;
    }

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
