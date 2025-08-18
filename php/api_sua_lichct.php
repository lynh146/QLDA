<?php
include("connect.php");

if (
    isset($_POST['MaLich']) &&
    isset($_POST['MaVuon']) &&
    isset($_POST['ThoiGian']) &&
    isset($_POST['CongViec']) &&
    isset($_POST['TrangThai'])
) {
    $MaLich = $_POST['MaLich'];
    $MaVuon = $_POST['MaVuon'];
    $ThoiGian = $_POST['ThoiGian'];
    $CongViec = $_POST['CongViec'];
    $TrangThai = $_POST['TrangThai'];

    $sql = "UPDATE lichct SET 
                MaVuon = '$MaVuon',
                ThoiGian = '$ThoiGian',
                CongViec = '$CongViec',
                TrangThai = '$TrangThai'
            WHERE MaLich = '$MaLich'";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Cập nhật thành công!";
    } else {
        echo "❌ Cập nhật thất bại!";
    }
} else {
    echo "❌ Thiếu dữ liệu!";
}
?>
