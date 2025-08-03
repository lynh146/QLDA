<?php
include "connect.php";

if (isset($_GET['MaTruyXuat'])) {
    $MaTruyXuat = $_GET['MaTruyXuat'];

    $sql = "DELETE FROM truyxuat WHERE MaTruyXuat = '$MaTruyXuat'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Xóa dữ liệu thành công!');
                window.location.href='../lay_thong_tin_truyxuat.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi xóa: " . $conn->error . "');
                window.location.href='../lay_thong_tin_truyxuat.html';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Không có mã truy xuất để xóa!');
            window.location.href='../lay_thong_tin_truyxuat.html';
          </script>";
}
?>
