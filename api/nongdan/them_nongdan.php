<?php
require __DIR__ . '/../../config/connect.php';

$TenND    = $_POST['TenND']    ?? '';
$CCCD     = $_POST['CCCD']     ?? '';
$DiaChi   = $_POST['DiaChi']   ?? '';
$SDT      = $_POST['SDT']      ?? '';
$Email    = $_POST['Email']    ?? '';
$Username = $_POST['Username'] ?? '';
$MatKhau  = $_POST['MatKhau']  ?? '';

if ($TenND=="" || $CCCD=="" || $Username=="" || $MatKhau=="") {
    die("❌ Vui lòng nhập đủ thông tin");
}

try {
    // Tạo MaND tự động
    $stmt = $conn->query("SELECT MAX(MaND) as maxid FROM nongdan");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxid = $row['maxid'];
    $num = $maxid ? intval(substr($maxid,2)) + 1 : 1;
    $MaND = "ND" . str_pad($num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO nongdan(MaND,TenND,CCCD,DiaChi,SDT,Email,Username,MatKhau)
            VALUES(?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$MaND,$TenND,$CCCD,$DiaChi,$SDT,$Email,$Username,$MatKhau]);

    echo "✅ Thêm nông dân thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
