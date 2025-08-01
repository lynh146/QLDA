<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaTT = $_POST['MaTT'];
    $MaLo = $_POST['MaLo'];
    $Ngay = $_POST['Ngay'];
    $NhietDo = $_POST['NhietDo'];
    $LuongMua = $_POST['LuongMua'];
    $DoAm = $_POST['DoAm'];

    // Kiểm tra trùng MaTT
    $check = "SELECT MaTT FROM thoitiet WHERE MaTT = '$MaTT'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        echo "<script>
                alert('❌ Mã thời tiết \"$MaTT\" đã tồn tại. Vui lòng nhập mã khác!');
                window.history.back();
              </script>";
        exit();
    }

    // Thêm dữ liệu
    $sql = "INSERT INTO thoitiet (MaTT, MaLo, Ngay, NhietDo, LuongMua, DoAm) 
            VALUES ('$MaTT', '$MaLo', '$Ngay', '$NhietDo', '$LuongMua', '$DoAm')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thêm dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thoitiet.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi thêm dữ liệu: " . addslashes($conn->error) . "');
                window.history.back();
              </script>";
    }
}
?>
