<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maVuon  = $_POST['MaVuon'] ?? '';
$maGiong = $_POST['MaGiong'] ?? '';
$dienTich = $_POST['DienTich'] ?? 0;
$ngayBD   = $_POST['NgayBD'] ?? '';
$ngayKT   = $_POST['NgayKT'] ?? '';

try {
    // Nếu là user thì chỉ được thêm lô trong vườn của mình
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT MaND FROM vuon WHERE MaVuon = ?");
        $check->execute([$maVuon]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm lô cho vườn này";
            exit;
        }
    }

    // Sinh mã lô mới (L001, L002…)
    $sqlMax = "SELECT MaLo FROM losx ORDER BY MaLo DESC LIMIT 1";
    $res = $conn->query($sqlMax);
    $last = $res->fetchColumn();

    if ($last) {
        $num = (int)substr($last, 1) + 1; // bỏ chữ L
    } else {
        $num = 1;
    }
    $maLo = "L" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Thêm lô SX
    $sql = "INSERT INTO losx (MaLo, MaVuon, MaGiong, DienTich, NgayBD, NgayKT) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maLo, $maVuon, $maGiong, $dienTich, $ngayBD, $ngayKT]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
