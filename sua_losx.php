<?php
include 'connect.php';

$MaLo = $_POST['MaLo'];
$MaVuon = $_POST['MaVuon'];
$MaGiong = $_POST['MaGiong'];
$DienTich = $_POST['DienTich'];
$NgayBD = $_POST['NgayBD'];
$NgayKT = $_POST['NgayKT'];

$sql = "UPDATE losx 
        SET MaVuon = ?, MaGiong = ?, DienTich = ?, NgayBD = ?, NgayKT = ?
        WHERE MaLo = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsss", $MaVuon, $MaGiong, $DienTich, $NgayBD, $NgayKT, $MaLo);

if ($stmt->execute()) {
    echo "Cập nhật lô sản xuất thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}
?>
