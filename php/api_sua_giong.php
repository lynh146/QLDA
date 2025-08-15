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

    $sql = "UPDATE giong SET 
                TenGiong = '$TenGiong',
                NguonGoc = '$NguonGoc',
                TGTruong = '$TGTruong',
                NangSuatTB = '$NangSuatTB'
            WHERE MaGiong = '$MaGiong'";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Cập nhật thành công!";
    } else {
        echo "❌ Cập nhật thất bại!";
    }
} else {
    echo "❌ Thiếu dữ liệu!";
}
?>
