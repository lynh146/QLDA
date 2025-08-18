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
$thoiGian = $_POST['ThoiGian'] ?? '';
$congViec = $_POST['CongViec'] ?? '';
$trangThai= $_POST['TrangThai'] ?? 'Chưa thực hiện';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT MaND FROM vuon WHERE MaVuon=?");
        $check->execute([$maVuon]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm lịch cho vườn này";
            exit;
        }
    }

    // Sinh mã lịch mới
    $sqlMax = "SELECT MaLich FROM lich ORDER BY MaLich DESC LIMIT 1";
    $res = $conn->query($sqlMax);
    $last = $res->fetchColumn();

    if ($last) {
        $num = (int)substr($last, 2) + 1; // bỏ LC
    } else {
        $num = 1;
    }
    $maLich = "LC" . str_pad($num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO lich (MaLich, MaVuon, ThoiGian, CongViec, TrangThai) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLich, $maVuon, $thoiGian, $congViec, $trangThai]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
