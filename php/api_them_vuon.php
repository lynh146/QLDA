<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaVuon = $_POST['MaVuon'];
    $MaND = $_POST['MaND'];
    $TenVuon = $_POST['TenVuon'];
    $DienTich = $_POST['DienTich'];
    $LoaiDat = $_POST['LoaiDat'];
    $ViTri = $_POST['ViTri'];
    $TrangThai = $_POST['TrangThai'];

    // Kiểm tra trùng mã
    $check = "SELECT MaVuon FROM vuon WHERE MaVuon = '$MaVuon'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        echo "<script>
                alert('❌ Mã vườn \"$MaVuon\" đã tồn tại. Vui lòng nhập mã khác!');
                window.history.back();
              </script>";
        exit();
    }

    $sql = "INSERT INTO vuon (MaVuon, MaND, TenVuon, DienTich, LoaiDat, ViTri, TrangThai) 
            VALUES ('$MaVuon', '$MaND', '$TenVuon', '$DienTich', '$LoaiDat', '$ViTri', '$TrangThai')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thêm dữ liệu thành công!');
                window.location.href='../lay_thong_tin_vuon.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Lỗi khi thêm dữ liệu: " . addslashes($conn->error) . "');
                window.history.back();
              </script>";
    }
}
?>
