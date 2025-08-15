<?php
include("connect.php");

if (isset($_POST['MaBC'])) {
    $MaBC = $_POST['MaBC'];

    $sql = "DELETE FROM baocao WHERE MaBC = '$MaBC'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Xoá thành công!";
    } else {
        echo "❌ Xoá thất bại!";
    }
} else {
    echo "❌ Thiếu mã báo cáo để xoá!";
}
?>
