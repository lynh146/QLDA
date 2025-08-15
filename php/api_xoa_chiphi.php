<?php
include("connect.php");

if (isset($_POST['MaCP'])) {
    $MaCP = $_POST['MaCP'];

    $sql = "DELETE FROM chiphi WHERE MaCP = '$MaCP'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Xoá thành công!";
    } else {
        echo "❌ Xoá thất bại!";
    }
} else {
    echo "❌ Thiếu mã chi phí để xoá!";
}
?>
