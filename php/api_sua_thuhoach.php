<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['MaTH'] ?? '';
    $malo = $_POST['MaLo'] ?? '';
    $ngay = $_POST['NgayTH'] ?? '';
    $sanluong = $_POST['SanLuong'] ?? '';
    $chatluong = $_POST['ChatLuong'] ?? '';

    if (empty($id) || empty($malo) || empty($ngay)) {
        echo "❌ Thiếu dữ liệu!";
        exit;
    }

    $sql = "UPDATE thuhoach 
            SET MaLo='$malo', NgayTH='$ngay', SanLuong='$sanluong', ChatLuong='$chatluong' 
            WHERE MaTH='$id'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "✅ Đã sửa thành công!";
        } else {
            echo "⚠ Không có dòng nào bị thay đổi.";
        }
    } else {
        echo "❌ Lỗi SQL: " . $conn->error;
    }
}
?>
