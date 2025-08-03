<?php
include 'connect.php';

$MaND = $_POST['MaND'];
$TenND = $_POST['TenND'];
$CCCD = $_POST['CCCD'];
$DiaChi = $_POST['DiaChi'];
$SDT = $_POST['SDT'];

$sql = "UPDATE nongdan SET TenND=?, CCCD=?, DiaChi=?, SDT=? WHERE MaND=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $TenND, $CCCD, $DiaChi, $SDT, $MaND);

echo $stmt->execute() ? "Cập nhật nông dân thành công" : "Lỗi: " . $stmt->error;
?>
