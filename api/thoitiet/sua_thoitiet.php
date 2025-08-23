<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTT = $_POST['MaTT'] ?? '';
$maLo = $_POST['MaLo'] ?? '';
$ngay = $_POST['Ngay'] ?? '';
$nhietDo = $_POST['NhietDo'] ?? '';
$luongMua = $_POST['LuongMua'] ?? '';
$doAm = $_POST['DoAm'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM thoitiet t
                                 JOIN losx l ON t.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE t.MaTT=?");
        $check->execute([$maTT]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền sửa dữ liệu này";
            exit;
        }
    }

    $ngay = str_replace("T", " ", $ngay);
    if ($ngay && strlen($ngay) == 16) $ngay .= ":00";

    $sql = "UPDATE thoitiet 
            SET MaLo=?, Ngay=?, NhietDo=?, LuongMua=?, DoAm=? 
            WHERE MaTT=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $ngay, $nhietDo, $luongMua, $doAm, $maTT]);

    echo "✅ Sửa Thời tiết thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
