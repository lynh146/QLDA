<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maVuon    = $_POST['MaVuon'] ?? '';
$tenTB     = $_POST['TenTB'] ?? '';
$loaiTB    = $_POST['LoaiTB'] ?? '';
$ngayCaiDat = $_POST['NgayCaiDat'] ?? '';
$trangThai = $_POST['TrangThai'] ?? '';

try {
    if ($role !== 'admin') {
        // Kiểm tra quyền sở hữu vườn
        $check = $conn->prepare("SELECT MaND FROM vuon WHERE MaVuon=?");
        $check->execute([$maVuon]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm thiết bị cho Vườn này";
            exit;
        }
    }

    // Sinh mã TB mới (TB001, TB002…)
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaTB,3) AS UNSIGNED)) AS MaxNum FROM thietbi";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maTB = "TB" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Chuẩn hóa datetime-local
    $ngayCaiDat = str_replace("T", " ", $ngayCaiDat);
    if ($ngayCaiDat && strlen($ngayCaiDat) == 16) {
        $ngayCaiDat .= ":00";
    }

    // Insert
    $sql = "INSERT INTO thietbi(MaTB, MaVuon, TenTB, LoaiTB, NgayCaiDat, TrangThai)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTB, $maVuon, $tenTB, $loaiTB, $ngayCaiDat, $trangThai]);

    echo "✅ Thêm Thiết bị thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
