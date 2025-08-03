<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaThuoc = $_POST['MaThuoc'];
    $MaLo = $_POST['MaLo'];
    $TenThuoc = $_POST['TenThuoc'];
    $SoLuong = $_POST['SoLuong'];
    $DonVi = $_POST['DonVi'];
    $NgaySD = $_POST['NgaySD'];

    // Kiểm tra trùng mã
    $check = "SELECT MaThuoc FROM thuoc WHERE MaThuoc = '$MaThuoc'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        echo "<script>
                alert('❌ Mã thuốc \"$MaThuoc\" đã tồn tại. Vui lòng nhập mã khác!');
                window.history.back();
              </script>";
        exit();
    }

    $sql = "INSERT INTO thuoc (MaThuoc, MaLo, TenThuoc, SoLuong, DonVi, NgaySD) 
            VALUES ('$MaThuoc', '$MaLo', '$TenThuoc', '$SoLuong', '$DonVi', '$NgaySD')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thêm dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thuoc.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi thêm dữ liệu: " . addslashes($conn->error) . "');
                window.history.back();
              </script>";
    }
}
?>
