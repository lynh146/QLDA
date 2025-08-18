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
$ngayGhi   = $_POST['NgayGhi'] ?? '';
$noiDung   = $_POST['NoiDung'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';

try {
    if ($role !== 'admin') {
        // Kiểm tra quyền: MaLo có thuộc nông dân này không?
        $check = $conn->prepare("
            SELECT v.MaND 
            FROM losx l
            JOIN vuon v ON l.MaVuon = v.MaVuon
            WHERE l.MaLo = ?
        ");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm nhật ký cho Lô này";
            exit;
        }
    }

    // Sinh mã NK mới (NK001, NK002…)
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaNK,3) AS UNSIGNED)) AS MaxNum FROM nhatky";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maNK = "NK" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Insert
    $sql = "INSERT INTO nhatky (MaNK, MaLo, NgayGhi, NoiDung, TrangThai) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maNK, $maLo, $ngayGhi, $noiDung, $trangThai]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
