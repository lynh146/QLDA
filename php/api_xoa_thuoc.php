<?php
include "connect.php";

if (isset($_GET['MaThuoc'])) {
    $MaThuoc = $_GET['MaThuoc'];

    $sql = "DELETE FROM thuoc WHERE MaThuoc = '$MaThuoc'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Xóa dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thuoc.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi xóa: " . $conn->error . "');
                window.location.href='../lay_thong_tin_thuoc.html';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Không có mã thuốc để xóa!');
            window.location.href='../lay_thong_tin_thuoc.html';
          </script>";
}
?>
