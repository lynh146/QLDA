<?php
include "connect.php";

if (isset($_GET['MaTH'])) {
    $MaTH = $_GET['MaTH'];

    $sql = "DELETE FROM thuhoach WHERE MaTH = '$MaTH'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Xóa dữ liệu thành công!');
                window.location.href='../lay_thong_tin_thuhoach.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi xóa: " . $conn->error . "');
                window.location.href='../lay_thong_tin_thuhoach.html';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Không có mã thu hoạch để xóa!');
            window.location.href='../lay_thong_tin_thuhoach.html';
          </script>";
}
?>
