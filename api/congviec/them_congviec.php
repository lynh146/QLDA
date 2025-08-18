<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLo      = $_POST['MaLo'] ?? '';
$tenCV     = $_POST['TenCV'] ?? '';
$ngayBD    = $_POST['NgayBD'] ?? '';
$ngayKT    = $_POST['NgayKT'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';
$ghiChu    = $_POST['GhiChu'] ?? '';

try {
    if ($role !== 'admin') {
        // Kiểm tra quyền: lô có thuộc nông dân này không?
        $check = $conn->prepare("
            SELECT v.MaND 
            FROM losx l
            JOIN vuon v ON l.MaVuon = v.MaVuon
            WHERE l.MaLo = ?
        ");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm công việc cho Lô này";
            exit;
        }
    }

    // Sinh mã CV mới (CV001, CV002...)
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaCV,3) AS UNSIGNED)) AS MaxNum FROM congviec";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maCV = "CV" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Thêm công việc
    $sql = "INSERT INTO congviec (MaCV, MaLo, TenCV, NgayBD, NgayKT, TrangThai, GhiChu) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maCV, $maLo, $tenCV, $ngayBD, $ngayKT, $trangThai, $ghiChu]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
