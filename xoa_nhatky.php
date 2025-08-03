<?php
include 'connect.php';

$MaNK = $_POST['MaNK'];

$sql = "DELETE FROM nhatky WHERE MaNK=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaNK);

if ($stmt->execute()) {
    echo "Xóa nhật ký thành công";
} else {
    echo "Lỗi: " . $stmt->error;
}
?>
