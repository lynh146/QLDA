<?php
include 'connect.php';
extract($_POST);
$sql = "INSERT INTO losx (MaLo, MaVuon, MaGiong, DienTich, NgayBD, NgayKT) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssddd", $MaLo, $MaVuon, $MaGiong, $DienTich, $NgayBD, $NgayKT);
echo $stmt->execute() ? "OK" : "Lỗi: ".$stmt->error;
?>
