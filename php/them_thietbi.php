<?php
include 'connect.php';

$MaTB = $_POST['MaTB'];
$MaVuon = $_POST['MaVuon'];
$TenTB = $_POST['TenTB'];
$LoaiTB = $_POST['LoaiTB'];
$NgayCaiDat = $_POST['NgayCaiDat'];
$TrangThai = $_POST['TrangThai'];

$sql = "INSERT INTO thietbi (MaTB, MaVuon, TenTB, LoaiTB, NgayCaiDat, TrangThai) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $MaTB, $MaVuon, $TenTB, $LoaiTB, $NgayCaiDat, $TrangThai);

echo $stmt->execute() ? "Thêm thiết bị thành công" : "Lỗi: " . $stmt->error;
?>
