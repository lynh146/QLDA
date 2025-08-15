<?php
include("connect.php");

if (isset($_POST['MaLich'])) {
    $MaLich = $_POST['MaLich'];

    $sql = "DELETE FROM lichct WHERE MaLich = '$MaLich'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Xoá thành công!";
    } else {
        echo "❌ Xoá thất bại!";
    }
} else {
    echo "❌ Thiếu mã lịch để xoá!";
}
?>
