<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'nongdan') {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit;
}

$maND = $_SESSION['id'];

// Lấy tên nông dân
$sql = "SELECT TenND FROM nongdan WHERE MaND = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$maND]);
$name = $stmt->fetchColumn();

// Đếm số vườn
$sql = "SELECT COUNT(*) FROM vuon WHERE MaND = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$maND]);
$vuon = $stmt->fetchColumn();

// Đếm số lô sản xuất
$sql = "SELECT COUNT(*) 
        FROM losx l 
        JOIN vuon v ON l.MaVuon = v.MaVuon 
        WHERE v.MaND = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$maND]);
$losx = $stmt->fetchColumn();

// Tổng sản lượng thu hoạch
$sql = "SELECT SUM(t.SanLuong) 
        FROM thuhoach t 
        JOIN losx l ON t.MaLo = l.MaLo 
        JOIN vuon v ON l.MaVuon = v.MaVuon 
        WHERE v.MaND = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$maND]);
$thuhoach = $stmt->fetchColumn() ?: 0;

// Công việc tuần
$sql = "SELECT COUNT(*) 
        FROM congviec c 
        JOIN losx l ON c.MaLo = l.MaLo 
        JOIN vuon v ON l.MaVuon = v.MaVuon 
        WHERE v.MaND = ? 
        AND WEEK(c.NgayBD) = WEEK(CURDATE())";
$stmt = $conn->prepare($sql);
$stmt->execute([$maND]);
$congviec = $stmt->fetchColumn();

echo json_encode([
    "name" => $name ?: "Nông dân",
    "vuon" => (int)$vuon,
    "losx" => (int)$losx,
    "thuhoach" => (float)$thuhoach,
    "congviec" => (int)$congviec
], JSON_UNESCAPED_UNICODE);
