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

    $check = "SELECT * FROM chiphi WHERE MaCP = '$MaCP'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Mã chi phí đã tồn tại!";
    } else {
        $sql = "INSERT INTO chiphi (MaCP, MaVuon, LoaiCP, SoTien, NgayPhat)
                VALUES ('$MaCP', '$MaVuon', '$LoaiCP', '$SoTien', '$NgayPhat')";
        if (mysqli_query($conn, $sql)) {
            echo "✅ Thêm thành công!";
        } else {
            echo "❌ Thêm thất bại!";
        }
    }
} else {
    echo "❌ Thiếu dữ liệu!";
}
?>
