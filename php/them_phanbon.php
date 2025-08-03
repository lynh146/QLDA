<?php
include 'connect.php';

$MaPhan = $_POST['MaPhan'];
$MaLo = $_POST['MaLo'];
$TenPhan = $_POST['TenPhan'];
$SoLuong = $_POST['SoLuong'];
$DonVi = $_POST['DonVi'];
$NgaySD = $_POST['NgaySD'];

$sql = "INSERT INTO phanbon (MaPhan, MaLo, TenPhan, SoLuong, DonVi, NgaySD) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdds", $MaPhan, $MaLo, $TenPhan, $SoLuong, $DonVi, $NgaySD);

echo $stmt->execute() ? "Thêm phân bón thành công" : "Lỗi: " . $stmt->error;
?>
