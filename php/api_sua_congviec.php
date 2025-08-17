<?php
include("connect.php");

if (
    isset($_POST['MaCV']) &&
    isset($_POST['MaLo']) &&
    isset($_POST['TenCV']) &&
    isset($_POST['NgayBD']) &&
    isset($_POST['NgayKT']) &&
    isset($_POST['TrangThai']) &&
    isset($_POST['GhiChu'])
) {
    $MaCV = $_POST['MaCV'];
    $MaLo = $_POST['MaLo'];
    $TenCV = $_POST['TenCV'];
    $NgayBD = $_POST['NgayBD'];
    $NgayKT = $_POST['NgayKT'];
    $TrangThai = $_POST['TrangThai'];
    $GhiChu = $_POST['GhiChu'];

    $sql = "UPDATE congviec SET 
                MaLo = '$MaLo',
                TenCV = '$TenCV',
                NgayBD = '$NgayBD',
                NgayKT = '$NgayKT',
                TrangThai = '$TrangThai',
                GhiChu = '$GhiChu'
            WHERE MaCV = '$MaCV'";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Cập nhật thành công!";
    } else {
        echo "❌ Cập nhật thất bại!";
    }
} else {
    echo "❌ Thiếu dữ liệu!";
}
?>
