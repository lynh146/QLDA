<?php
include 'connect.php';

$MaPhan = $_POST['MaPhan'];
$MaLo = $_POST['MaLo'];
$TenPhan = $_POST['TenPhan'];
$SoLuong = $_POST['SoLuong'];
$DonVi = $_POST['DonVi'];
$NgaySD = $_POST['NgaySD'];

$sql = "UPDATE phanbon SET MaLo=?, TenPhan=?, SoLuong=?, DonVi=?, NgaySD=? WHERE MaPhan=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsss", $MaLo, $TenPhan, $SoLuong, $DonVi, $NgaySD, $MaPhan);

echo $stmt->execute() ? "Cập nhật phân bón thành công" : "Lỗi: " . $stmt->error;
?>
