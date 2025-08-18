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
        // Admin: xem toàn bộ phân bón
        $sql = "SELECT p.*, n.TenND
                FROM phanbon p
                JOIN losx l ON p.MaLo = l.MaLo
                JOIN vuon v ON l.MaVuon = v.MaVuon
                JOIN nongdan n ON v.MaND = n.MaND";
        $stmt = $conn->query($sql);
    } else {
        // Nông dân: chỉ xem phân bón của lô thuộc mình
        $sql = "SELECT p.* 
                FROM phanbon p
                JOIN losx l ON p.MaLo = l.MaLo
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
