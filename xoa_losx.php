<?php
include 'connect.php';

$MaLo = $_POST['MaLo'];

$sql = "DELETE FROM losx WHERE MaLo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaLo);

if ($stmt->execute()) {
    echo "Xóa lô sản xuất thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}
?>
