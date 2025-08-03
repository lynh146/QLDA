<?php
include 'connect.php';

$MaND = $_POST['MaND'];

$sql = "DELETE FROM nongdan WHERE MaND=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaND);

echo $stmt->execute() ? "Xóa thành công" : "Lỗi: " . $stmt->error;
?>
