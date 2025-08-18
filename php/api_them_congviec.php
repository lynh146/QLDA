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

    $check = "SELECT * FROM congviec WHERE MaCV = '$MaCV'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Mã công việc đã tồn tại!";
    } else {
        $sql = "INSERT INTO congviec (MaCV, MaLo, TenCV, NgayBD, NgayKT, TrangThai, GhiChu)
                VALUES ('$MaCV', '$MaLo', '$TenCV', '$NgayBD', '$NgayKT', '$TrangThai', '$GhiChu')";
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
