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

    if (empty($MaVuon) || empty($MaND) || empty($TenVuon)) {
        echo "❌ Thiếu dữ liệu!";
        exit;
    }

    $sql = "UPDATE vuon 
            SET MaND='$MaND', TenVuon='$TenVuon', DienTich='$DienTich', 
                LoaiDat='$LoaiDat', ViTri='$ViTri', TrangThai='$TrangThai'
            WHERE MaVuon='$MaVuon'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "✅ Đã sửa thành công!";
        } else {
            echo "⚠ Không có thay đổi (dữ liệu có thể trùng).";
        }
    } else {
        echo "❌ Lỗi SQL: " . $conn->error;
    }
}
?>
