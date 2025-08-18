<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLo    = $_POST['MaLo']    ?? '';
$tenPhan = $_POST['TenPhan'] ?? '';
$soLuong = $_POST['SoLuong'] ?? 0;
$donVi   = $_POST['DonVi']   ?? '';
$ngaySD  = $_POST['NgaySD']  ?? '';

try {
    if ($role !== 'admin') {
        // Kiểm tra lô có thuộc nông dân này không
        $check = $conn->prepare("
            SELECT v.MaND 
            FROM losx l
            JOIN vuon v ON l.MaVuon = v.MaVuon
            WHERE l.MaLo = ?
        ");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm phân bón cho Lô này";
            exit;
        }
    }

    // Sinh mã Phân mới (PB001, PB002,…)
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaPhan,3) AS UNSIGNED)) AS MaxNum FROM phanbon";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maPhan = "PB" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Chuẩn hóa datetime-local: "2025-08-18T12:00" → "2025-08-18 12:00:00"
    $ngaySD = str_replace("T", " ", $ngaySD);
    if (strlen($ngaySD) == 16) {
        $ngaySD .= ":00";
    }

    // Insert
    $sql = "INSERT INTO phanbon (MaPhan, MaLo, TenPhan, SoLuong, DonVi, NgaySD)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maPhan, $maLo, $tenPhan, $soLuong, $donVi, $ngaySD]);

    echo "✅ Thêm Phân bón thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
