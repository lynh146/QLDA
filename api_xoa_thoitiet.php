<?php
include "connect.php"; // Kết nối database

if (isset($_GET['MaTT'])) {
    $MaTT = $_GET['MaTT'];

    // Câu lệnh xóa
    $sql = "DELETE FROM thoitiet WHERE MaTT = '$MaTT'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Xóa dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thoitiet.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi xóa: " . $conn->error . "');
                window.location.href='../lay_thong_tin_thoitiet.html';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Không có mã thời tiết để xóa!');
            window.location.href='../lay_thong_tin_thoitiet.html';
          </script>";
}
?>
