<?php
include("connect.php");

if (
    isset($_POST['MaCP']) &&
    isset($_POST['MaVuon']) &&
    isset($_POST['LoaiCP']) &&
    isset($_POST['SoTien']) &&
    isset($_POST['NgayPhat'])
) {
    $MaCP = $_POST['MaCP'];
    $MaVuon = $_POST['MaVuon'];
    $LoaiCP = $_POST['LoaiCP'];
    $SoTien = $_POST['SoTien'];
    $NgayPhat = $_POST['NgayPhat'];

    $sql = "UPDATE chiphi SET 
                MaVuon = '$MaVuon',
                LoaiCP = '$LoaiCP',
                SoTien = '$SoTien',
                NgayPhat = '$NgayPhat'
            WHERE MaCP = '$MaCP'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Cập nhật thành công!";
    } else {
        echo "❌ Cập nhật thất bại!";
    }
} else {
    echo "❌ Thiếu dữ liệu!";
}
?>
