<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLo = $_POST['MaLo'] ?? '';
$ngay = $_POST['Ngay'] ?? '';
$nhietDo = $_POST['NhietDo'] ?? '';
$luongMua = $_POST['LuongMua'] ?? '';
$doAm = $_POST['DoAm'] ?? '';

try {
    if ($role !== 'admin') {
        // kiểm tra lô có thuộc nông dân không
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM losx l 
                                 JOIN vuon v ON l.MaVuon = v.MaVuon 
                                 WHERE l.MaLo=?");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm thời tiết cho Lô này";
            exit;
        }
    }

    // sinh mã TT mới
    $sqlMax = "SELECT MAX(CAST(SUBSTRING(MaTT,3) AS UNSIGNED)) AS MaxNum FROM thoitiet";
    $res = $conn->query($sqlMax);
    $row = $res->fetch();
    $num = $row['MaxNum'] ? $row['MaxNum'] + 1 : 1;
    $maTT = "TT" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // chuẩn hóa ngày
    $ngay = str_replace("T", " ", $ngay);
    if ($ngay && strlen($ngay) == 16) $ngay .= ":00";

    $sql = "INSERT INTO thoitiet(MaTT, MaLo, Ngay, NhietDo, LuongMua, DoAm) 
            VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTT, $maLo, $ngay, $nhietDo, $luongMua, $doAm]);

    echo "✅ Thêm Thời tiết thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
