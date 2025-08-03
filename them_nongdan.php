<?php
include 'connect.php';

$MaND = $_POST['MaND'];
$TenND = $_POST['TenND'];
$CCCD = $_POST['CCCD'];
$DiaChi = $_POST['DiaChi'];
$SDT = $_POST['SDT'];

$sql = "INSERT INTO nongdan (MaND, TenND, CCCD, DiaChi, SDT) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $MaND, $TenND, $CCCD, $DiaChi, $SDT);

echo $stmt->execute() ? "Thêm nông dân thành công" : "Lỗi: " . $stmt->error;
?>
