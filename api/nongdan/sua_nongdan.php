<?php
require __DIR__ . '/../../config/connect.php';

$MaND     = $_POST['MaND']     ?? '';
$TenND    = $_POST['TenND']    ?? '';
$CCCD     = $_POST['CCCD']     ?? '';
$DiaChi   = $_POST['DiaChi']   ?? '';
$SDT      = $_POST['SDT']      ?? '';
$Email    = $_POST['Email']    ?? '';
$Username = $_POST['Username'] ?? '';
$MatKhau  = $_POST['MatKhau']  ?? '';

if ($MaND=="") {
    die("❌ Thiếu mã nông dân");
}

try {
    $sql = "UPDATE nongdan
            SET TenND=?, CCCD=?, DiaChi=?, SDT=?, Email=?, Username=?, MatKhau=?
            WHERE MaND=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$TenND,$CCCD,$DiaChi,$SDT,$Email,$Username,$MatKhau,$MaND]);

    echo "✅ Cập nhật nông dân thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
