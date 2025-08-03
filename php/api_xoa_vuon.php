<?php
include "connect.php";

if (isset($_GET['MaVuon'])) {
    $MaVuon = $_GET['MaVuon'];

    $sql = "DELETE FROM vuon WHERE MaVuon = '$MaVuon'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Xóa dữ liệu thành công!');
                window.location.href='../lay_thong_tin_vuon.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi xóa: " . $conn->error . "');
                window.location.href='../lay_thong_tin_vuon.html';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Không có mã vườn để xóa!');
            window.location.href='../lay_thong_tin_vuon.html';
          </script>";
}
?>
