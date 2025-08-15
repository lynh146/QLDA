<?php
include("connect.php");

if (isset($_POST['MaGiong'])) {
    $MaGiong = $_POST['MaGiong'];

    $sql = "DELETE FROM giong WHERE MaGiong = '$MaGiong'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Xoá thành công!";
    } else {
        echo "❌ Xoá thất bại!";
    }
} else {
    echo "❌ Thiếu mã giống để xoá!";
}
?>
