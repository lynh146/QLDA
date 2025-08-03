<?php
include 'connect.php';

$MaTB = $_POST['MaTB'];
$MaVuon = $_POST['MaVuon'];
$TenTB = $_POST['TenTB'];
$LoaiTB = $_POST['LoaiTB'];
$NgayCaiDat = $_POST['NgayCaiDat'];
$TrangThai = $_POST['TrangThai'];

$sql = "UPDATE thietbi SET MaVuon=?, TenTB=?, LoaiTB=?, NgayCaiDat=?, TrangThai=? WHERE MaTB=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $MaVuon, $TenTB, $LoaiTB, $NgayCaiDat, $TrangThai, $MaTB);

echo $stmt->execute() ? "Cập nhật thiết bị thành công" : "Lỗi: " . $stmt->error;
?>
