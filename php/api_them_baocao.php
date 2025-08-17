<?php
include("connect.php");

if (
    isset($_POST['MaBC']) &&
    isset($_POST['LoaiBC']) &&
    isset($_POST['ThoiGian']) &&
    isset($_POST['NoiDung'])
) {
    $MaBC = $_POST['MaBC'];
    $LoaiBC = $_POST['LoaiBC'];
    $ThoiGian = $_POST['ThoiGian'];
    $NoiDung = $_POST['NoiDung'];

    $check = "SELECT * FROM baocao WHERE MaBC = '$MaBC'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Mã báo cáo đã tồn tại!";
    } else {
        $sql = "INSERT INTO baocao (MaBC, LoaiBC, ThoiGian, NoiDung)
                VALUES ('$MaBC', '$LoaiBC', '$ThoiGian', '$NoiDung')";
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
