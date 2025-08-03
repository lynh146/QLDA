<?php
include 'connect.php';

$MaTB = $_POST['MaTB'];

$sql = "DELETE FROM thietbi WHERE MaTB=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaTB);

echo $stmt->execute() ? "Xóa thiết bị thành công" : "Lỗi: " . $stmt->error;
?>
