<?php
include("connect.php");

if (isset($_POST['MaCV'])) {
    $MaCV = $_POST['MaCV'];

    $sql = "DELETE FROM congviec WHERE MaCV = '$MaCV'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Xoá thành công!";
    } else {
        echo "❌ Xoá thất bại!";
    }
} else {
    echo "❌ Thiếu mã công việc để xoá!";
}
?>
