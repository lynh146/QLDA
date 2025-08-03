<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaTH = $_POST['MaTH'];
    $MaLo = $_POST['MaLo'];
    $NgayTH = $_POST['NgayTH'];
    $SanLuong = $_POST['SanLuong'];
    $ChatLuong = $_POST['ChatLuong'];

    // Kiểm tra trùng MaTH
    $check = "SELECT MaTH FROM thuhoach WHERE MaTH = '$MaTH'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        echo "<script>
                alert('❌ Mã thu hoạch \"$MaTH\" đã tồn tại. Vui lòng nhập mã khác!');
                window.history.back();
              </script>";
        exit();
    }

    // Thêm dữ liệu
    $sql = "INSERT INTO thuhoach (MaTH, MaLo, NgayTH, SanLuong, ChatLuong) 
            VALUES ('$MaTH', '$MaLo', '$NgayTH', '$SanLuong', '$ChatLuong')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thêm dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thuhoach.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi thêm dữ liệu: " . addslashes($conn->error) . "');
                window.history.back();
              </script>";
    }
}
?>
