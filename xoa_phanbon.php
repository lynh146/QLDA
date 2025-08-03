<?php
include 'connect.php';

$MaPhan = $_POST['MaPhan'];

$sql = "DELETE FROM phanbon WHERE MaPhan=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaPhan);

echo $stmt->execute() ? "Xóa phân bón thành công" : "Lỗi: " . $stmt->error;
?>
