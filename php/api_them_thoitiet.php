<?php
include "connect.php"; // file kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaTT = $_POST['MaTT'];
    $MaLo = $_POST['MaLo'];
    $Ngay = $_POST['Ngay'];
    $NhietDo = $_POST['NhietDo'];
    $LuongMua = $_POST['LuongMua'];
    $DoAm = $_POST['DoAm'];

    $sql = "INSERT INTO thoitiet (MaTT, MaLo, Ngay, NhietDo, LuongMua, DoAm) 
            VALUES ('$MaTT', '$MaLo', '$Ngay', '$NhietDo', '$LuongMua', '$DoAm')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thêm dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thoitiet.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi thêm dữ liệu: " . $conn->error . "');
                window.location.href='../lay_thong_tin_thoitiet.html';
              </script>";
    }
}
?>
