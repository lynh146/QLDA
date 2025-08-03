<?php
include 'connect.php';

$MaNK = $_POST['MaNK'];
$MaLo = $_POST['MaLo'];
$NgayGhi = $_POST['NgayGhi'];
$NoiDung = $_POST['NoiDung'];
$TrangThai = $_POST['TrangThai'];

$sql = "INSERT INTO nhatky (MaNK, MaLo, NgayGhi, NoiDung, TrangThai) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $MaNK, $MaLo, $NgayGhi, $NoiDung, $TrangThai);

if ($stmt->execute()) {
    echo "Thêm nhật ký thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}
?>
