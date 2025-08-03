<?php
include 'connect.php';

$MaNK = $_POST['MaNK'];
$MaLo = $_POST['MaLo'];
$NgayGhi = $_POST['NgayGhi'];
$NoiDung = $_POST['NoiDung'];
$TrangThai = $_POST['TrangThai'];

$sql = "UPDATE nhatky SET MaLo=?, NgayGhi=?, NoiDung=?, TrangThai=? WHERE MaNK=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $MaLo, $NgayGhi, $NoiDung, $TrangThai, $MaNK);

if ($stmt->execute()) {
    echo "Cập nhật nhật ký thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}
?>
