<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maCP    = $_POST['MaCP'] ?? '';
$maVuon  = $_POST['MaVuon'] ?? '';
$loaiCP  = $_POST['LoaiCP'] ?? '';
$soTien  = $_POST['SoTien'] ?? 0;
$ngayPhat = $_POST['NgayPhat'] ?? '';

try {
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND 
                                 FROM chiphi c 
                                 JOIN vuon v ON c.MaVuon = v.MaVuon 
                                 WHERE c.MaCP = ?");
        $check->execute([$maCP]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "Bạn không có quyền sửa chi phí này";
            exit;
        }
    }

    $sql = "UPDATE chiphi 
            SET MaVuon=?, LoaiCP=?, SoTien=?, NgayPhat=? 
            WHERE MaCP=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maVuon, $loaiCP, $soTien, $ngayPhat, $maCP]);

    echo "OK";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
