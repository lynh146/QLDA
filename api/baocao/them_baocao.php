<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maVuon   = $_POST['MaVuon'] ?? '';
$loaiBC   = $_POST['LoaiBC'] ?? '';
$thoiGian = $_POST['ThoiGian'] ?? '';
$noiDung  = $_POST['NoiDung'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT * FROM vuon WHERE MaVuon=? AND MaND=?");
        $check->execute([$maVuon, $maND]);
        if ($check->rowCount() === 0) {
            echo "❌ Bạn không có quyền thêm báo cáo cho vườn này";
            exit;
        }
    }

    // Sinh mã báo cáo mới: BC001, BC002...
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaBC,3) AS UNSIGNED)) AS MaxNum FROM baocao";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maBC = "BC" . str_pad($num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO baocao (MaBC, MaVuon, LoaiBC, ThoiGian, NoiDung)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maBC, $maVuon, $loaiBC, $thoiGian, $noiDung]);

    echo "✅ Thêm báo cáo thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
