<?php
include("connect.php");

if (
    isset($_POST['MaGiong']) &&
    isset($_POST['TenGiong']) &&
    isset($_POST['NguonGoc']) &&
    isset($_POST['TGTruong']) &&
    isset($_POST['NangSuatTB'])
) {
    $MaGiong = $_POST['MaGiong'];
    $TenGiong = $_POST['TenGiong'];
    $NguonGoc = $_POST['NguonGoc'];
    $TGTruong = $_POST['TGTruong'];
    $NangSuatTB = $_POST['NangSuatTB'];

    $check = "SELECT * FROM giong WHERE MaGiong = '$MaGiong'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Mã giống đã tồn tại!";
    } else {
        $sql = "INSERT INTO giong (MaGiong, TenGiong, NguonGoc, TGTruong, NangSuatTB)
                VALUES ('$MaGiong', '$TenGiong', '$NguonGoc', '$TGTruong', '$NangSuatTB')";
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
