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

    $check = "SELECT * FROM lichct WHERE MaLich = '$MaLich'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Mã lịch đã tồn tại!";
    } else {
        $sql = "INSERT INTO lichct (MaLich, MaVuon, ThoiGian, CongViec, TrangThai)
                VALUES ('$MaLich', '$MaVuon', '$ThoiGian', '$CongViec', '$TrangThai')";
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
